<?php

namespace backend\controllers;

use common\models\SignupAdmin;
use common\models\User;
use common\models\UserSearch;
use common\models\Avaliacao;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class UserController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            ['access' => [

                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [

                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['acederBackend'],
                    ],

                ],
            ]
            ]
        );
    }


    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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



    public function actionPerfil($id)
    {
        $model = $this->findModel($id);
        $perfil = $model->perfil;
        $avaliacoes = Avaliacao::find()->where(['perfil_id' => $perfil->id])->all();

        return $this->render('perfil', [
            'model' => $this->findModel($id),
            'avaliacoes' => $avaliacoes,
        ]);
    }

    public function actionAvaliacaoDelete($id)
    {
        $avaliacao = \common\models\Avaliacao::findOne($id);

        if ($avaliacao) {
            $userId = $avaliacao->perfil->user_id;
            $avaliacao->delete();
            return $this->redirect(['perfil', 'id' => $userId]);
        }
            return $this->redirect(['index']);
    }


    public function actionSignup()
    {
        $model = new SignupAdmin();


        if ($model->load(Yii::$app->request->post()) && $model->signupAdmin()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
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


    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        $model->status = 9; // inativo
        $model->save(false);

        Yii::$app->session->setFlash('warning', 'Utilizador desativado com sucesso.');
        return $this->redirect(['index']);
    }

    public function actionReactivate($id)
    {
        $model = $this->findModel($id);
        $model->status = 10; // ou 1, conforme o teu "status ativo"
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Utilizador reativado com sucesso.');
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
