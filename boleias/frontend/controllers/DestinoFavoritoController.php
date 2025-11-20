<?php

namespace frontend\controllers;
use Yii;
use common\models\DestinoFavorito;
use common\models\DestinoFavoritoSearch;
use common\models\Perfil;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * DestinoFavoritoController implements the CRUD actions for DestinoFavorito model.
 */
class DestinoFavoritoController extends Controller
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
            ]
        );
    }

    /**
     * Lists all DestinoFavorito models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DestinoFavoritoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DestinoFavorito model.
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
     * Creates a new DestinoFavorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DestinoFavorito();

        if ($this->request->isPost) {
            $perfil = Perfil::findOne(['user_id'=>\Yii::$app->user->id]);
            $model->load($this->request->post());

            $model->setAttribute('perfil_id',$perfil->id);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSalvar()
    {
        $boleia_id = Yii::$app->request->post('boleia_id');
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);

        // Evitar duplicados
        if (!DestinoFavorito::find()->where([
            'perfil_id' => $perfil->id
        ])->exists()) {

            $favorito = new DestinoFavorito();
            $favorito->perfil_id = $perfil->id;
            $favorito->endereco = $boleia_id;
            $favorito->tipo = 'destino';
            $favorito->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    

    /**
     * Updates an existing DestinoFavorito model.
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
     * Deletes an existing DestinoFavorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DestinoFavorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DestinoFavorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DestinoFavorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
