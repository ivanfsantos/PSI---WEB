<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use common\models\Reserva;
use common\models\Boleia;

class ReservaController extends Controller
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



    //post de reservas
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva

    public function actionCreate()
    {
        
        $body = Yii::$app->request->getBodyParams();
         
        $boleia_id = $body['boleia_id'] ?? Yii::$app->request->post('boleia_id') ?? null;
        $perfil_id = $body['perfil_id'] ?? Yii::$app->request->post('perfil_id') ?? null;
        $ponto_encontro = $body['ponto_encontro'] ?? Yii::$app->request->post('ponto_encontro') ?? null;
        $contacto = $body['contacto'] ?? Yii::$app->request->post('contacto') ?? null;
        


        if (!$boleia_id || !$perfil_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Perfil_id e boleia_id são obrigatórios',
            ];
        }

        $reserva = new Reserva();
        $reserva->boleia_id = $boleia_id;
        $reserva->perfil_id = $perfil_id;
        $reserva->ponto_encontro = $ponto_encontro;
        $reserva->contacto = $contacto;
        $reserva->estado = 'Pendente';
        $reserva->reembolso = 0;

        $existeReserva = Reserva::find()->where([
            'boleia_id' => $boleia_id,
            'perfil_id' => $perfil_id,
        ])->one();

        if($existeReserva){
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Já existe uma reserva para esta boleia com este perfil',
            ];
        }


        if ($reserva->save()) {
            $boleia = Boleia::findOne($boleia_id);
            $boleia->lugares_disponiveis--;
            $boleia->save(false);
            return [
                'success' => true,
                'message' => 'Reserva criada com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao criar a reserva',
            ];
        }
    }



    //delete reserva por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva/?id=numero

    public function actionDelete(){

        $id = Yii::$app->request->get('id');
        $reserva = Reserva::findOne($id);
        if (!$reserva) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Reserva não encontrada',
            ];
        }

        if ($reserva->delete()) {

            $boleia = $reserva->boleia;
            $boleia->lugares_disponiveis++;
            $boleia->save(false);

            return [
                'success' => true,
                'message' => 'Reserva eliminada com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao eliminar a reserva',
            ];
        }
    }



    //get reservas de um perfil
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva/?perfil_id=numero

    public function actionIndex(){

        $perfil = Yii::$app->request->get('perfil_id');

        if (!$perfil) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo perfil_id é obrigatório na URL',
            ];
        }

        $reservas = Reserva::find()->where(['perfil_id' => $perfil])->all();

        return [
            'success' => true,
            'data' => $reservas,
        ];

    }




    //get reserva por id com detalhes da boleia e viatura
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva/?id=numero

    public function actionView(){

        $id = Yii::$app->request->get('id');
        $reserva = Reserva::findOne($id);

        if (!$reserva) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Reserva nao foi encontrada',
            ];
        }

        return [
            'success' => true,
            'data' => $reserva,
            'boleia' => $reserva->boleia,
            'viatura' => $reserva->boleia->viatura,
        ];
    }

    //put de reservas
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva/?id=numero

    public function actionUpdate(){

        $id = Yii::$app->request->get('id');
        $reserva = Reserva::findOne($id);

        if (!$reserva) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Reserva nao foi encontrada',
            ];
        }

        $body = Yii::$app->request->getBodyParams();

        if($reserva->estado == "Pago"){
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Não é possível alterar uma reserva já paga',
            ];
        }

        $reserva->attributes = $body;

        if ($reserva->save()) {
            return [
                'success' => true,
                'data' => $reserva,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao atualizar a reserva',
                'errors' => $reserva->errors,
            ];
        }
    }
    


    // get reservas de uma boleia
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva/reservas/?boleia_id=numero

    public function actionReservas()
    {
        $boleia_id = Yii::$app->request->get('boleia_id');

        if (!$boleia_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo boleia_id é obrigatório na URL',
            ];
        }


        $reservas = Reserva::find()->where(['boleia_id' => $boleia_id])->all();
        return [
            'success' => true,
            'data' => $reservas,
        ];
    }

    //post de reservas, o condutor valida as reservas pendentes de uma boleia
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/reserva/validar/?boleia_id=numero

    public function actionValidar()
    {
        $boleia_id = Yii::$app->request->get('boleia_id');

        if (!$boleia_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'O campo boleia_id é obrigatório na URL',
            ];
        }

        $reservas = Reserva::find()->where(['boleia_id' => $boleia_id, 'estado' => "Pendente"])->all();

        if (!$reservas) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Nenhuma reserva pendente encontrada',
            ];
        }
        
        $boleia = Boleia::findOne($boleia_id);
        if (!$boleia) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Boleia não encontrada',
            ];
        }

        $totalPassageiros = count($reservas);
        $precoTotal = $boleia->preco;

        foreach ($reservas as $reserva) {
            $reserva->estado = "Pago";
            $valorPorPassageiro = round($precoTotal / $totalPassageiros, 2);
            $reserva->reembolso = round($precoTotal - $valorPorPassageiro, 2);
            $reserva->save(false);

            $boleia = $reserva->boleia;
            $boleia->save(false);
        }

        return [
            'success' => true,
            'message' => 'Reservas validadas com sucesso',
        ];

    }

};