<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use common\models\Boleia;
use yii\filters\auth\QueryParamAuth;

class BoleiaController extends Controller
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

    //post de boleias
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/boleia

    
    public function actionCreate()
    {

        $body = Yii::$app->request->getBodyParams();
        
        $origem = $body['origem'] ?? Yii::$app->request->post('origem') ?? null;
        $destino = $body['destino'] ?? Yii::$app->request->post('destino') ?? null;
        $data_hora = $body['data_hora'] ?? Yii::$app->request->post('data_hora') ?? null;
        $lugares = $body['lugares_disponiveis'] ?? Yii::$app->request->post('lugares_disponiveis') ?? null;
        $preco = $body['preco'] ?? Yii::$app->request->post('preco') ?? null;
        $viatura_id = $body['viatura_id'] ?? Yii::$app->request->post('viatura_id') ?? null;

        if (!$origem || !$destino || !$data_hora || !$lugares || !$preco || !$viatura_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Campos obrigatórios em falta',
            ];
        }


        $boleiaExistente = Boleia::find()
                ->where(['viatura_id' => $viatura_id])
                ->andWhere(['between', 'data_hora',
                    date('Y-m-d 00:00:00', strtotime($data_hora)),
                    date('Y-m-d 23:59:59', strtotime($data_hora))
                ])
                ->exists();

        if($boleiaExistente) {
        Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Esta viatura já possui uma boleia criada para esta data.',
                ];
        }   
        
        $boleia = new Boleia();
        $boleia->origem = $origem;
        $boleia->destino = $destino;
        $boleia->data_hora = $data_hora;
        $boleia->lugares_disponiveis = $lugares;
        $boleia->preco = $preco;
        $boleia->viatura_id = $viatura_id;

           
        if ($boleia->save()) {
            return [
                'success' => true,
                'message' => 'Boleia criada com sucesso',
                'boleia_id' => $boleia->id,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Falha ao criar a Boleia',
                'errors' => $boleia->errors,
            ];
        }
    }

    //get todas as boleias
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/boleia

    public function actionIndex(){

        $boleias = Boleia::find()->all();
         $boleiasFechadas = array_filter($boleias, function($boleia) {
        return $boleia->isFechada(); 
    });

        return [
            'success' => true,
            'data' => $boleias,
            'boleias_fechadas' => $boleiasFechadas,
        ];

    }

    //get boleia por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/boleia/?id=numero

    public function actionView(){

        $id = Yii::$app->request->get('id');
        $boleia = Boleia::findOne($id);

        if (!$boleia) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Boleia nao foi encontrada',
            ];
        }

        return [
            'success' => true,
            'data' => $boleia,
            'viatura' => $boleia->viatura,
        ];
    }


    //del boleia por id 
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/boleia/?id=numero

    public function actionDelete(){

        $id = Yii::$app->request->get('id');
        $boleia = Boleia::findOne($id);

        if (!$boleia) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Boleia nao foi encontrada',
            ];
        }

        if ($boleia->delete()) {
            return [
                'success' => true,
                'message' => 'Boleia apagada com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Falha ao apagar a Boleia',
            ];
        }
    }

    //put boleia por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/boleia/?id=numero

    public function actionUpdate(){

        $id = Yii::$app->request->get('id');
        $boleia = Boleia::findOne($id);

        if (!$boleia) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Boleia nao foi encontrada',
            ];
        }

        $body = Yii::$app->request->getBodyParams();

        $boleia->attributes = $body;

        if ($boleia->save()) {
            return [
                'success' => true,
                'message' => 'Boleia atualizada com sucesso',
                'data' => $boleia,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Falha ao atualizar a Boleia',
                'errors' => $boleia->errors,
            ];
        }
    }
}