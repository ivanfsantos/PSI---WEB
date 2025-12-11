<?php

namespace frontend\controllers;
use Yii;
use common\models\DestinoFavorito;
use common\models\DestinoFavoritoSearch;
use common\models\Perfil;
use yii\base\ErrorException;
use yii\base\Model;
use yii\db\Exception;
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
        $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
        if (!$perfil) {
            throw new NotFoundHttpException('Perfil não encontrado.');
        }

        $searchModel = new DestinoFavoritoSearch();

        // Aqui filtramos pelo perfil do usuário logado
        $dataProvider = $searchModel->search(array_merge(
            Yii::$app->request->queryParams,
            ['DestinoFavoritoSearch' => ['perfil_id' => $perfil->id]]
        ));

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
    public function actionCreate($boleia_id)
    {

       $perfil = Perfil::findOne(['user_id'=>Yii::$app->user->id]);

       if(!$perfil)
       {
           throw new NotFoundHttpException('Perfil nao encontrado');
       }

       $model = new DestinoFavorito();

       $model->perfil_id = $perfil->id;
       $model->boleia_id = $boleia_id;

       $existe = DestinoFavorito::find()->where(['perfil_id'=>$model->perfil->id,
                                                'boleia_id'=>$model->boleia_id ])->one();

       if($existe){
           return $this->redirect(Yii::$app->request->referrer);
       }
       if($model->save())
       {
           return $this->redirect(Yii::$app->request->referrer);
       }else
       {
           throw new ErrorException('Nao foi possivel adicionar a viagem á wishlist');
       }
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

        return $this->redirect(Yii::$app->request->referrer);
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
