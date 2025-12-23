<?php

namespace frontend\controllers;

use Yii;
use common\models\DestinoFavorito;
use common\models\DestinoFavoritoSearch;
use common\models\Perfil;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\ErrorException;

class DestinoFavoritoController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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
            Yii::$app->session->setFlash('error', 'É preciso criar um perfil antes de aceder à watchlist.');
            return $this->redirect(['/site/index']);
        }

        $searchModel = new DestinoFavoritoSearch();
        $dataProvider = $searchModel->search(array_merge(
            Yii::$app->request->queryParams,
            ['DestinoFavoritoSearch' => ['perfil_id' => $perfil->id]]
        ));

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





    public function actionCreate($boleia_id)
    {
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        if (!$perfil) {
            throw new NotFoundHttpException('Perfil nao encontrado');
        }


        $model = new DestinoFavorito();
        $model->perfil_id = $perfil->id;
        $model->boleia_id = $boleia_id;

        $existe = DestinoFavorito::find()->where([
            'perfil_id' => $model->perfil->id,
            'boleia_id' => $model->boleia_id
        ])->one();

        if ($existe) {
        
            return $this->redirect(Yii::$app->request->referrer);
             throw new ErrorException('Já existe este destino nos favoritos');

        } else if($model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
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

        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = DestinoFavorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
