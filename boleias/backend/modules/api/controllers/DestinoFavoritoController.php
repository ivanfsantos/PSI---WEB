<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use common\models\DestinoFavorito;
use common\models\Boleia;

class DestinoFavoritoController extends Controller
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }


    //post de destinos favoritos
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/destino-favorito

    public function actionCreate()
    {

        $body = Yii::$app->request->getBodyParams();
        $perfil_id = $body['perfil_id'] ?? Yii::$app->request->post('perfil_id') ?? null;
        $boleia_id = $body['boleia_id'] ?? Yii::$app->request->post('boleia_id') ?? null;

        if (!$boleia_id || !$perfil_id) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Perfil_id e boleia_id são obrigatórios',
            ];
        }

        $existe = DestinoFavorito::find()->where([
            'perfil_id' => $perfil_id,
            'boleia_id' => $boleia_id,
        ])->one();

        $boleia = Boleia::findOne($boleia_id);

        if($boleia->isFechada()){
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Não é possível adicionar boleias fechadas à watchlist',
            ];
        }
        
        if($existe){
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Destino já está na watchlist',
            ];
        }

        $destinoFavorito = new DestinoFavorito();
        $destinoFavorito->perfil_id = $perfil_id;
        $destinoFavorito->boleia_id = $boleia_id;

        if ($destinoFavorito->save()) {
            return [
                'success' => true,
                'message' => 'Adicionado com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao adicionar aos favoritos',
            ];
        }
    }


    


    //get destino favorito por id com detalhes da boleia e viatura
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/destino-favorito/?id=numero

    public function actionView()
    {
        $id = Yii::$app->request->get('id');

        $destino = DestinoFavorito::findOne($id);

        if (!$destino) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Destino favorito não encontrado',
            ];
        }

        return [
            'success' => true,
            'data' => $destino->boleia,
            'viatura' => $destino->boleia->viatura,
        ];
    }





    //get destinos favoritos de um perfil
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/destino-favorito/?perfil_id=numero


    public function actionIndex()
    {   

        $perfil_id = Yii::$app->request->get('perfil_id');

        if(!$perfil_id){
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'perfil_id é obrigatório',
            ];
        }

        $destinos = DestinoFavorito::find()->where(['perfil_id' => $perfil_id])->all();
        
        foreach($destinos as $destino){
            $destino->boleia;
            $destino->boleia->viatura;
        }

        return [
            'success' => true,
            'data' => $destinos,
            'boleia' => $destino->boleia,
        ];
    }




    //delete destino favorito por id
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/destino-favorito/?id=numero

    public function actionDelete($id)
    {

        $id = Yii::$app->request->get('id');

        $destinoFavorito = DestinoFavorito::findOne($id);

        if (!$destinoFavorito) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Não encontrado',
            ];
        }

        if ($destinoFavorito->delete()) {
            return [
                'success' => true,
                'message' => 'Eliminado com sucesso',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao eliminar da wishlist',
            ];
        }
    }
}