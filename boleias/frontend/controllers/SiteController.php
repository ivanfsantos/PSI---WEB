<?php

namespace frontend\controllers;

use common\models\Boleia;
use common\models\BoleiaSearch;
use common\models\Documento;
use common\models\LoginForm;
use common\models\Perfil;
use common\models\Reserva;
use common\models\Viatura;
use frontend\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'create'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['criarBoleia'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => ['class' => \yii\web\ErrorAction::class],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }


        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        $searchModel = new BoleiaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perfil' => $perfil,
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
        $model = new Boleia();
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);

        if (!$perfil) {
            Yii::$app->session->setFlash('error', 'O seu perfil não foi encontrado.');
            return $this->redirect(['site/index']);
        }

        $existeDocumentoValido = Documento::find()
            ->where(['perfil_id' => $perfil->id, 'valido' => 1])
            ->exists();

        if (!$existeDocumentoValido) {
            Yii::$app->session->setFlash('error', 'É necessário ter pelo menos um documento válido para criar uma boleia.');
            return $this->redirect(['documento/index', 'id' => $perfil->user->id]);
        }

        $viaturasUser = Viatura::find()->where(['perfil_id' => $perfil->id])->all();
        if (empty($viaturasUser)) {
            Yii::$app->session->setFlash('error', 'É necessário ter pelo menos uma viatura para criar uma boleia.');
            return $this->redirect(['viatura/create', 'id' => $perfil->id]);
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $boleiaExistente = Boleia::find()
                ->where(['viatura_id' => $model->viatura_id])
                ->andWhere(['between', 'data_hora',
                    date('Y-m-d 00:00:00', strtotime($model->data_hora)),
                    date('Y-m-d 23:59:59', strtotime($model->data_hora))
                ])
                ->exists();

            if ($boleiaExistente) {
                Yii::$app->session->setFlash('error', 'Esta viatura já possui uma boleia criada para esta data.');
                return $this->redirect(['site/index']);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Boleia criada com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'viaturas' => $viaturasUser,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        $viaturasUser = Viatura::find()->where(['perfil_id' => $perfil->id])->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'viaturas' => $viaturasUser,
        ]);
    }

    public function actionDelete($id)
    {
        $boleia = $this->findModel($id);
        $userIdLogado = Yii::$app->user->id;

        if ($boleia->viatura->perfil->user_id != $userIdLogado) {
            throw new \yii\web\ForbiddenHttpException('Não pode apagar.');
        }

        $viatura = $boleia->viatura;
        $reservasBoleia = Reserva::find()->where(['boleia_id' => $boleia->id])->all();

        $boleia->delete();

        foreach ($reservasBoleia as $reserva) {
            $reserva->delete();
            $viatura->lugares_disponiveis++;
            $viatura->save();
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Boleia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', ['model' => $model]);
    }
}
