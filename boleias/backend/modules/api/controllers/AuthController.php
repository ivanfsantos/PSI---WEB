<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use common\models\User;

class AuthController extends Controller
{

    //post de login
    //http://localhost/PROJETOS/boleias/web/PSI-WEB/boleias/backend/web/api/auth

    public function actionLogin()
    {
        $body = Yii::$app->request->getBodyParams();
        
        $username = $body['username'] ?? Yii::$app->request->post('username') ?? null;
        $password = $body['password'] ?? Yii::$app->request->post('password') ?? null;


        if (!$username || !$password) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Username e password são obrigatórios',
            ];
        }

        $user = User::findByUsername($username);

        if (!$user ){
            return [
                'success' => false,
                'message' => 'User não encontrado',
            ];
        }

        if(!$user->validatePassword($password)) {
            return [
                'success' => false,
                'message' => 'Password inválida',
            ];
        }

        $perfil = $user->perfil;

        if(!$perfil) {
            return [
                'success' => false,
                'message' => 'Sem perfil associado ao utilizador.',
            ];
        }

        $documentos = $perfil->documentos;

        foreach($documentos as $documento) {
            if ($documento->valido == 0) {
                
                    return [
                        'success' => false,
                        'message' => 'Documentos inválidos. Contacte a administração.',
                    ];
                
            }
        }

        return [
            'success' => true,
            'token' => $user->auth_key,
            'user_id' => $user->id,
            'perfil_id' => $perfil->id,
            'nomePerfil' => $perfil->nome,
            'condutor' => $perfil->condutor,
        ];
    }
}