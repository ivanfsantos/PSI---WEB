<?php

namespace backend\modules\api\controllers;


use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\Controller;

class ApiController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // CORS (vem sempre antes)
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        // Autenticação
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
            //'except' => ['index', 'view', 'options'],
        ];

        return $behaviors;
    }
}
