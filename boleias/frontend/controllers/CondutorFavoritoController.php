<?php

namespace frontend\controllers;

use common\models\Boleia;
use common\models\BoleiaSearch;
use common\models\CondutorFavorito;
use common\models\CondutorFavoritoSearch;
use common\models\Perfil;
use common\models\Viatura;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CondutorFavoritoController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete', 'boleias'],
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

    public function actionIndex()
    {
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        if (!$perfil) {
            Yii::$app->session->setFlash('error', 'É preciso criar um perfil antes de aceder aos condutores favoritos.');
            return $this->redirect(['/site/index']);
        }

        $searchModel = new CondutorFavoritoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['perfil_id_user' => $perfil->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBoleias($id)
    {
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        if (!$perfil) {
            throw new NotFoundHttpException('Perfil não encontrado.');
        }

        $viaturas = Viatura::find()
            ->select('id')
            ->where(['perfil_id' => $id])
            ->column();

        $boleias = empty($viaturas) ? [] : Boleia::find()->where(['viatura_id' => $viaturas])->all();

        return $this->render('boleias', [
            'boleias' => $boleias,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id)
    {
        $passageiroPerfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        if (!$passageiroPerfil) {
            throw new NotFoundHttpException('Perfil do passageiro não encontrado.');
        }

        $jaExiste = CondutorFavorito::find()
            ->where([
                'perfil_id_user' => $passageiroPerfil->id,
                'perfil_id_condutor' => $id,
            ])
            ->exists();

        if (!$jaExiste) {
            $model = new CondutorFavorito();
            $model->perfil_id_user = $passageiroPerfil->id;
            $model->perfil_id_condutor = $id;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Condutor adicionado com sucesso.');
            } else {
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao salvar o favorito.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Condutor já existe na sua tabela de favoritos.');
        }

        return $this->redirect($this->request->referrer ?: ['site/index']);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect($this->request->referrer ?: ['site/index']);
    }

    protected function findModel($id)
    {
        if (($model = CondutorFavorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
