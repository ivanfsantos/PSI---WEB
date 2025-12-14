<?php

namespace frontend\controllers;

use common\models\Documento;
use common\models\DocumentoSearch;
use common\models\Perfil;
use common\models\UploadDocumentoCarta;
use common\models\UploadDocumentoCartao;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DocumentoController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['acederDocumento'],
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
        $userId = Yii::$app->user->id;
        $perfil = Perfil::findOne(['user_id' => $userId]);
        if (!$perfil) {
            throw new NotFoundHttpException('O utilizador ainda nao tem perfil associado.');
        }

        $searchModel = new DocumentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['perfil_id' => $perfil->id]);

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

    public function actionCreate()
    {
        $message = "";
        $model = new Documento();
        $modelUploadCarta = new UploadDocumentoCarta();
        $modelUploadCartao = new UploadDocumentoCartao();

        if ($this->request->isPost) {
            $userId = Yii::$app->user->id;
            $perfil = Perfil::findOne(['user_id' => $userId]);
            if (!$perfil) {
                throw new NotFoundHttpException('O utilizador ainda nao tem perfil associado.');
            }

            $documentoExistente = Documento::findOne(['perfil_id' => $perfil->id]);
            if ($documentoExistente) {
                if ($documentoExistente->valido) {
                    throw new BadRequestHttpException('Os documentos ja foram validados');
                }
                $message = "Documentos atualizados com sucesso!";
            }

            $modelUploadCarta->cartaFile = UploadedFile::getInstance($modelUploadCarta, 'cartaFile');
            $modelUploadCartao->cartaoFile = UploadedFile::getInstance($modelUploadCartao, 'cartaoFile');

            $cartaFileName = $modelUploadCarta->upload($userId . '-carta-conducao');
            $cartaoFileName = $modelUploadCartao->upload($userId . '-cartao-cidadao');

            if (!$documentoExistente) {
                $model->setAttributes([
                    'carta_conducao' => $cartaFileName,
                    'cartao_cidadao' => $cartaoFileName,
                    'valido' => 0,
                    'perfil_id' => $perfil->id,
                ]);
                $model->save();
                $message = "Documentos enviado com sucesso";
            }

            if (!$cartaoFileName || !$cartaFileName) {
                $message = "";
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUploadCarta' => $modelUploadCarta,
            'modelUploadCartao' => $modelUploadCartao,
            'message' => $message,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Documento::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
