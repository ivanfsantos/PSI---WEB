<?php

namespace backend\controllers;

use app\models\User;
use common\models\Documento;
use common\models\LoginForm;
use common\models\SignupAdmin;
use common\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                'access' => [

                    'class' => AccessControl::class,
                    'only' => ['signup' ,'index','create'],
                    'rules' => [
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['acederBackend'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $qtdDocumentosPendentes = Documento::find()->where(['valido' => 0])->count();

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $qtdUsersRegisto = $dataProvider->query->count();

        return $this->render('index', [
            'qtdDocumentosPendentes' => $qtdDocumentosPendentes,
            'qtdUsersRegisto' => $qtdUsersRegisto,
        ]);
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

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
