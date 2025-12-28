<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use common\models\Perfil;
use common\models\Avaliacao;

class AvaliacaoController extends Controller
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

    //post de avaliacoes
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/avaliacao

    public function actionCreate()
    {

        $body = Yii::$app->request->getBodyParams();
        
        $perfil_id = $body['perfil_id'] ?? Yii::$app->request->post('perfil_id') ?? null;
        $descricao = $body['descricao'] ?? Yii::$app->request->post('descricao') ?? null;

        if (!$perfil_id || !$descricao) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Os campos perfil_id e descricao são obrigatórios',
            ];
        }

        $avaliacao = new Avaliacao();
        $avaliacao->perfil_id = $perfil_id;
        $avaliacao->descricao = $descricao;

        if ($avaliacao->save()) {
            return [
                'success' => true,
                'data' => $avaliacao,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao salvar a avaliação',
                'errors' => $avaliacao->errors,
            ];
        }
    }

    //get avaliacoes por perfil_id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/avaliacao/?perfil_id=numero

    public function actionIndex(){

        $perfil_id = Yii::$app->request->get('perfil_id') ?? null;

        if (!$perfil_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo perfil_id é obrigatório',
            ];
        }

        $avaliacoes = Avaliacao::find()->where(['perfil_id' => $perfil_id])->all();
        return [
            'success' => true,
            'data' => $avaliacoes,
        ];
    }

    //get avaliacao por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/avaliacao/?id=numero

    public function actionView(){

        $id = Yii::$app->request->get('id');

        $avaliacao = Avaliacao::findOne($id);

        if (!$avaliacao) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Avaliação não encontrada',
            ];
        }

        return [
            'success' => true,
            'data' => $avaliacao,
        ];


    }

    //delete avaliacao por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/avaliacao/?id=numero

    public function actionDelete(){

        $id = Yii::$app->request->get('id');
        $avaliacao = Avaliacao::findOne($id);

        if (!$avaliacao) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Avaliação não encontrada',
            ];
        }

        if ($avaliacao->delete()) {
            return [
                'success' => true,
                'message' => 'Avaliação eliminada com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao eliminar a avaliação',
            ];
        }
   
    }

    //put avaliacao por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/avaliacao/?id=numero

    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $body = Yii::$app->request->getBodyParams();

        $avaliacao = Avaliacao::findOne($id);

        if (!$avaliacao) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Avaliação não encontrada',
            ];
        }

        $descricao = $body['descricao'] ?? Yii::$app->request->post('descricao') ?? null;

        if ($descricao !== null) {
            $avaliacao->descricao = $descricao;
        }

        if ($avaliacao->save()) {
            return [
                'success' => true,
                'data' => $avaliacao,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao atualizar a avaliação',
                'errors' => $avaliacao->errors,
            ];
        }
    }
    
};