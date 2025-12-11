<?php

namespace frontend\controllers;

use common\models\Boleia;
use common\models\BoleiaSearch;

use common\models\DestinoFavorito;
use common\models\DestinoFavoritoSearch;
use common\models\Documento;
use common\models\LoginForm;
use common\models\Perfil;


use common\models\Reserva;
use common\models\Viatura;

use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                'only' => ['logout', 'signup','create'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){

            $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);

            $searchModel = new BoleiaSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'perfil' => $perfil,
            ]);

        } else {
            return $this->redirect(['site/login']);
        }
    }

    public function actionAddFavorito($id)
    {
        $perfil = Perfil::findOne(['user_id'=>Yii::$app->user->id]);
        $favorito = DestinoFavorito::findOne(['boleia_id'=>$id,
            'perfil_id'=>$perfil->id]);

        // TODO: Se já existir um favorito, redireciono de volta para boleias
        // TODO: Se não existir nos favoritos, adiciono em DestinoFavorito e depois redireciono para lista de boleias
        // TODO: Depois que o inserir boleias estiver pronto, criar uma nova lista na view de boleias, apenas com os favoritos



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

        $viaturasUser = Viatura::find()->where(['perfil_id' => $perfil->id])->all();
        if (empty($viaturasUser)) {
            Yii::$app->session->setFlash('error', 'É necessário ter pelo menos uma viatura para criar uma boleia.');
            return $this->redirect(['viatura/create','id' => $perfil->id]);
        }

        $existeDocumentoValido = Documento::find()
            ->where(['perfil_id' => $perfil->id, 'valido' => 1])
            ->exists();

        if (!$existeDocumentoValido) {
            Yii::$app->session->setFlash('error', 'É necessário ter pelo menos um documento válido para criar uma boleia.');
            return $this->redirect(['documento/index', 'id' => $perfil->user->id]);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

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
            'viaturas' => $viaturasUser
        ]);
    }


    public function actionDelete($id)
    {
        $boleia = $this->findModel($id);
        $userIdLogado = Yii::$app->user->id;

        $viatura = $boleia->viatura;

        $reservasBoleia = Reserva::find()->where(['boleia_id' => $boleia->id])->all();

        if ($boleia->viatura->perfil->user_id != $userIdLogado) {
            throw new \yii\web\ForbiddenHttpException('não pode apagar.');
        }

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

    /**
     * Logs in a user.
     *
     * @return mixed
     */
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

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
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

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
