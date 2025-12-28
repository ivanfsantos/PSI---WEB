<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use common\models\Viatura;
use common\models\Perfil;

class ViaturaController extends Controller
{

   public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => QueryParamAuth::class,
        'tokenParam' => 'access-token',
    ];
    return $behaviors;
}

    //post de viaturas
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/viatura

    public function actionCreate()
    {

        $body = Yii::$app->request->getBodyParams();
        
        $marca = $body['marca'] ?? Yii::$app->request->post('marca') ?? null;
        $modelo = $body['modelo'] ?? Yii::$app->request->post('modelo') ?? null;
        $matricula = $body['matricula'] ?? Yii::$app->request->post('matricula') ?? null;
        $cor = $body['cor'] ?? Yii::$app->request->post('cor') ?? null;
        $perfil_id = $body['perfil_id'] ?? Yii::$app->request->post('perfil_id') ?? null;

        if (!$marca || !$modelo || !$matricula || !$cor || !$perfil_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Os campos são obrigatórios',
            ];
        }

        $viatura = Viatura::find()->where(['matricula' => $matricula])->one();
        if ($viatura) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Já existe uma viatura com essa matrícula',
            ];
        }

        $perfil = Perfil::findOne($perfil_id);
        if ($perfil->condutor == 0) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O perfil associado deve ser de um condutor',
            ];
        }

        $viatura = new Viatura();
        $viatura->marca = $marca;
        $viatura->modelo = $modelo;
        $viatura->matricula = $matricula;
        $viatura->cor = $cor;
        $viatura->perfil_id = $perfil_id;

        if ($viatura->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'success' => true,
                'message' => 'Viatura criada com sucesso',
                'data' => $viatura,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao criar a viatura',
                'errors' => $viatura->errors,
            ];
        }

    }

    //get todas as viaturas de um perfil
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/viatura/?perfil_id=numero


    public function actionIndex()
    {
        $perfil_id = Yii::$app->request->get('perfil_id');

        if (!$perfil_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo perfil_id é obrigatório na URL',
            ];
        }

        $viaturas = Viatura::find()->where(['perfil_id' => $perfil_id])->all();

        return [
            'success' => true,
            'data' => $viaturas,
        ];
    }


    //get viatura por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/viatura/?id=numero

    public function actionView()
    {
        $id = Yii::$app->request->get('id');

        if (!$id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo id é obrigatório na URL',
            ];
        }

        $viatura = Viatura::findOne($id);

        if (!$viatura) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Viatura não encontrada',
            ];
        }

        return [
            'success' => true,
            'data' => $viatura,
        ];
    }   

    //delete viatura por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/viatura/?id=numero

    public function actionDelete(){

        $id = Yii::$app->request->get('id');

        if (!$id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo id é obrigatório na URL',
            ];
        }

        $viatura = Viatura::findOne($id);

        if (!$viatura) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Viatura não encontrada',
            ];
        }

        if ($viatura->delete()) {
            return [
                'success' => true,
                'message' => 'Viatura eliminada com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao eliminar a viatura',
            ];
        }
    }

    //put viatura por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/viatura/?id=numero

    public function actionUpdate()
    {

        $id = Yii::$app->request->get('id');
        $viatura = Viatura::findOne($id);

        if (!$viatura) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Viatura não encontrada',
            ];
        }

        $body = Yii::$app->request->getBodyParams();

        $viatura->attributes = $body;

        if ($viatura->save()) {
            return [
                'success' => true,
                'message' => 'Viatura atualizada com sucesso',
                'data' => $viatura,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao atualizar a viatura',
                'errors' => $viatura->errors,
            ];
        }
    }
};