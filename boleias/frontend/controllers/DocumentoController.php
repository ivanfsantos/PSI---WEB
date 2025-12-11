<?php

namespace frontend\controllers;

use Cassandra\Exception\AlreadyExistsException;
use common\models\Documento;
use common\models\Perfil;
use common\models\UploadDocumentoCarta;
use common\models\UploadDocumentoCartao;
use frontend\models\DocumentoSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DocumentoController implements the CRUD actions for Documento model.
 */
class DocumentoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout', 'signup','index','create'],
                    'rules' => [
                        [
                            'actions' => ['index','create'],
                            'allow' => true,
                            'roles' => ['acederDocumento'],
                        ],
                    ],
                ],

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
     * Lists all Documento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocumentoSearch();
        $userId = Yii::$app->user->id;
        $perfilId = Perfil::findOne(['user_id' => $userId]);
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->andWhere(['perfil_id' => $perfilId]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Documento model.
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
     * Creates a new Documento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $message = "";

        $model = new Documento();

        $modelUploadCarta = new UploadDocumentoCarta();
        $modelUploadCartao = new UploadDocumentoCartao();

        if ($this->request->isPost) {

            $userId = \Yii::$app->user->getId();

            $perfil = Perfil::findOne(['user_id' =>$userId]);

            if(!$perfil)
            {
                throw new NotFoundHttpException('O utilizador ainda nao tem perfil associado.');
            }

            $documentoExistente = Documento::findOne(['perfil_id'=>$perfil->id]);

            if($documentoExistente)
            {
                if($documentoExistente->valido)
                {
                    throw new BadRequestHttpException('Os documentos ja foram validados');

                }

                // se o documento j]a existir no BD, n\ao precisamos de fazer nada,
                // ele apenas ser]a sobrescrito na pasta de arquivos
                $message = "Documentos atualizados com sucesso!";

            }

            $modelUploadCarta->cartaFile = UploadedFile::getInstance($modelUploadCarta, 'cartaFile');
            $modelUploadCartao->cartaoFile = UploadedFile::getInstance($modelUploadCartao , 'cartaoFile');


            $cartaFileName = $modelUploadCarta->upload($userId . '-carta-conducao');
            $cartaoFileName = $modelUploadCartao->upload($userId . '-cartao-cidadao');

            //criar uma variavel com os dados do documento
            //fazer um setAtributes
            //model->save
            if(!$documentoExistente)
            {
                $model->setAttributes([
                    'carta_conducao'=>$cartaFileName,
                    'cartao_cidadao'=>$cartaoFileName,
                    'valido'=>0,
                    'perfil_id'=>$perfil->id,
                ]);

                $model->save();
                $message="Documentos enviado com sucesso";
            }

            if(!$cartaoFileName || !$cartaFileName)
            {
                $message = "";
            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelUploadCarta'=>$modelUploadCarta,
            'modelUploadCartao'=>$modelUploadCartao,
            'message'=>$message

        ]);
    }

    /**
     * Updates an existing Documento model.
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
     * Deletes an existing Documento model.
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
     * Finds the Documento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Documento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
