<?php

namespace frontend\controllers;

use common\models\Boleia;
use common\models\Perfil;
use common\models\Reserva;
use common\models\ReservaSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function ActiveRecord\all;

/**
 * ReservaController implements the CRUD actions for Reserva model.
 */
class ReservaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

                'access' => [
                    'class' => AccessControl::className(),
                    'only' => [],
                    'rules' => [

                        [
                            'actions' => [],
                            'allow' => true,
                            'roles' => [],
                        ],

                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Reserva models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $perfil = Perfil::findOne(['user_id' => $id]);

        if (!$perfil) {
            Yii::$app->session->setFlash('error', 'É preciso criar um perfil antes de aceder às reservas.');
            return $this->redirect(['/site/index']);

        }


        $searchModel = new ReservaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->andWhere(['perfil_id' => $perfil->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReservas($id){


        $boleia = Boleia::findOne($id);

        if (!$boleia) {
            Yii::$app->session->setFlash('error', 'Boleia não encontrada!');
            return $this->redirect(['site/index']);
        }

        $perfil = Yii::$app->user->identity->perfil;

        if ($boleia->viatura->perfil_id != $perfil->id) {
            Yii::$app->session->setFlash('error', 'Não tem permissão para ver estas reservas.');
            return $this->redirect(['site/index']);
        }

        $query = Reserva::find()->where(['boleia_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index-reservas', [
            'dataProvider' => $dataProvider,
            'boleia_id' => $id,
        ]);
    }

    public function actionValidar($id){

        $reservas = Reserva::find()->where(['boleia_id' => $id, 'estado' => 'Pendente'])->all();

        if (empty($reservas)) {
            Yii::$app->session->setFlash('error', 'Não existem reservas pendentes para esta boleia!');
            return $this->redirect(['reservas', 'id' => $id]);
        }

        $boleia = $reservas[0]->boleia;

        if (!$boleia) {
            Yii::$app->session->setFlash('error', 'Boleia não encontrada!');
            return $this->redirect(['reservas', 'id' => $id]);
        }

        $totalPassageiros = Reserva::find()->where(['boleia_id' => $id])->count();
        $precoTotal = $boleia->preco;

        foreach ($reservas as $reserva) {
            $reserva->estado = 'Pago';

            $valorPorPassageiro = round($precoTotal / $totalPassageiros, 2);

            $reserva->reembolso = round($precoTotal - $valorPorPassageiro, 2);

            $reserva->save(false);
        }

        Yii::$app->session->setFlash('success', 'Todas as reservas foram validadas e os reembolsos calculados com sucesso!');
        return $this->redirect(['reservas', 'id' => $id]);
    }




    /**
     * Displays a single Reserva model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Reserva model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {

        $model = new Reserva();
        $userId = Yii::$app->user->identity->id;
        $perfil = Perfil::findOne(['user_id' => $userId]);

        if (!$perfil) {
            Yii::$app->session->setFlash('error', 'Por favor, complete o seu perfil primeiro.');
            return $this->redirect(['perfil/create']);
        }

        $hasExistingReservation = Reserva::find()
            ->where(['boleia_id' => $id, 'perfil_id' => $perfil->id])
            ->exists();

        if ($hasExistingReservation) {
            Yii::$app->session->setFlash('error', 'Já efetuou esta reserva para esta boleia.');
            return $this->redirect(['reserva/index', 'id'=> $userId]);
        }

        $model->perfil_id = $perfil->id;
        $model->boleia_id = $id;
        $model->reembolso = 0;

        $boleia = Boleia::findOne($id);

        if ($boleia->lugares_disponiveis <= 0) {
            Yii::$app->session->setFlash('error', 'Não há lugares disponíveis nesta boleia!');
            return $this->redirect(['index']); // Redirect back to trip listings
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $boleia->lugares_disponiveis--;
                $boleia->save(false);

                Yii::$app->session->setFlash('success', "Reserva efetuada com sucesso!");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'perfil_id' => $perfil->id,
            'boleia_id' => $id,
        ]);
    }

    /**
     * Updates an existing Reserva model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing Reserva model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $reserva = $this->findModel($id);

        $boleia = $reserva->boleia;
        $viatura = $boleia->viatura;

        $viatura->lugares_disponiveis++;
        $viatura->save(false);

        $reserva->delete();

        return $this->redirect(['/site/index']);
    }

    /**
     * Finds the Reserva model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reserva the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reserva::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
