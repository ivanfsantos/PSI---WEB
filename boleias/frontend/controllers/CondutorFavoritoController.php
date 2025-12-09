<?php

namespace frontend\controllers;

use common\models\CondutorFavorito;
use common\models\CondutorFavoritoSearch;
use common\models\Perfil;
use yii\base\ErrorException;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CondutorFavoritoController implements the CRUD actions for CondutorFavorito model.
 */
class CondutorFavoritoController extends Controller
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
     * Lists all CondutorFavorito models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CondutorFavoritoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CondutorFavorito model.
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
     * Creates a new CondutorFavorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($condutorId)
    {
        $perfil = Perfil::findOne(['user_id'=>\Yii::$app->user->id]);

        if(!$perfil){
            throw new NotFoundHttpException('Perfil nao encontrado');
        }

        $jaExiste = CondutorFavorito::find()->where(['passageiro_id'=>$perfil->id, 'condutor_id'=>$condutorId])->exists();

        if(!$jaExiste) {

            $model = new CondutorFavorito();

            $model->condutor_id = $condutorId;
            $model->passageiro_id = $perfil->id;

                if ($model->save()) {
                \Yii::error($model->errors, 'condutor-favorito');

                return $this->redirect($this->request->referrer ?: ['site/index']);

            }

        }
        return $this->redirect($this->request->referrer ?: ['site/index']);

    }

    /**
     * Updates an existing CondutorFavorito model.
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
     * Deletes an existing CondutorFavorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect($this->request->referrer ?: ['site/index']);

    }

    /**
     * Finds the CondutorFavorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CondutorFavorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CondutorFavorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
