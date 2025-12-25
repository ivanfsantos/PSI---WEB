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

class ReservaController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'reservas', 'create', 'validar', 'view', 'update', 'delete'],
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

    public function actionIndex($id)
    {
        $perfil = Perfil::findOne(['user_id' => $id]);
        if (!$perfil) {
            Yii::$app->session->setFlash('error', 'É preciso criar um perfil antes de aceder às reservas.');
            return $this->redirect(['/site/index']);
        }

        $searchModel = new ReservaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['perfil_id' => $perfil->id])
            ->with(['boleia.viatura.perfil']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionReservas($id)
    {
        
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
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index-reservas', [
            'dataProvider' => $dataProvider,
            'boleia_id' => $id,
        ]);
    }



    public function actionValidar($id)
    {
        $reservas = Reserva::find()->where(['boleia_id' => $id, 'estado' => 'Pendente'])->all();
        if (empty($reservas)) {
            Yii::$app->session->setFlash('error', 'Não existem reservas pendentes para esta boleia!');
            return $this->redirect(['reservas', 'id' => $id]);
        }

        $boleia = Boleia::findOne($id);
        if (!$boleia) {
            Yii::$app->session->setFlash('error', 'Boleia não encontrada!');
            return $this->redirect(['site/index']);
        }
        
        $totalPassageiros = count($reservas);
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



    

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id)
    {
        $model = new Reserva();
        $userId = Yii::$app->user->identity->id;
        $perfil = Perfil::findOne(['user_id' => $userId]);

        if (!$perfil) {
            Yii::$app->session->setFlash('error', 'Por favor, complete o seu perfil primeiro.');
            return $this->redirect(['perfil/create']);
        }

        $jaExiste = Reserva::find()->where(['boleia_id' => $id, 'perfil_id' => $perfil->id])->exists();
        if ($jaExiste) {
            Yii::$app->session->setFlash('error', 'Já efetuou esta reserva para esta boleia.');
            return $this->redirect(['index', 'id' => $userId]);
        }

        $boleia = Boleia::findOne($id);
        if (!$boleia) {
            Yii::$app->session->setFlash('error', 'Boleia não encontrada.');
            return $this->redirect(['site/index']);
        }

        if ($boleia->lugares_disponiveis <= 0) {
            Yii::$app->session->setFlash('error', 'Não há lugares disponíveis nesta boleia!');
            return $this->redirect(['site/index']);
        }

        $model->perfil_id = $perfil->id;
        $model->boleia_id = $id;
        $model->reembolso = 0;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $boleia->lugares_disponiveis--;
                $boleia->save(false);
                Yii::$app->session->setFlash('success', "Reserva efetuada com sucesso!");
                return $this->redirect(['index', 'id' => $userId]);
            } else {
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao salvar a reserva.');
                return $this->redirect(['index', 'id' => $userId]);
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
        $reserva = $this->findModel($id);
        $boleia = $reserva->boleia;
        $boleia->lugares_disponiveis++;
        $boleia->save(false);
        $reserva->delete();

        return $this->redirect(['/site/index']);
    }

    protected function findModel($id)
    {
        if (($model = Reserva::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
