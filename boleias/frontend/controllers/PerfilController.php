<?php

namespace frontend\controllers;

use common\models\Avaliacao;
use common\models\Perfil;
use common\models\PerfilSearch;
use common\models\Viatura;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PerfilController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete', 'perfil'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    public function actionPerfil($id)
    {
        $avaliacoes = Avaliacao::find()->where(['perfil_id' => $id])->all();

        return $this->render('perfil', [
            'model' => $this->findModel($id),
            'avaliacoes' => $avaliacoes,
        ]);
    }

    public function actionIndex($id)
    {
        $searchModel = new PerfilSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_id' => $id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        if ($perfil) {
            return $this->redirect(['index', 'id' => $perfil->user_id]);
        }

        $model = new Perfil();
        $model->user_id = Yii::$app->user->id;

        if ($model->load($this->request->post()) && $model->save()) {
            $auth = Yii::$app->authManager;
            $roleName = $model->condutor ? 'condutor' : 'passageiro';
            $role = $auth->getRole($roleName);
            if ($role) {
                $auth->assign($role, $model->user_id);
            }

            Yii::$app->session->setFlash('success', 'Perfil criado com sucesso!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->loadDefaultValues();

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->user_id);
            $roleName = $model->condutor ? 'condutor' : 'passageiro';
            $role = $auth->getRole($roleName);
            if ($role) {
                $auth->assign($role, $model->user_id);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Perfil::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Perfil não encontrado.");
        }

        $auth = Yii::$app->authManager;
        $roles = ['condutor', 'passageiro'];
        foreach ($roles as $roleName) {
            $role = $auth->getRole($roleName);
            if ($role) {
                $auth->revoke($role, $model->user_id);
            }
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Perfil removido com sucesso.');
        return $this->redirect(['index', 'id' => $model->user_id]);
    }

    protected function findModel($id)
    {
        if (($model = Perfil::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
