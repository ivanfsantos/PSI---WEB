<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\filters\auth\AuthInterface;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        // adciona a role "passageiro"
        $passageiro = $auth->createRole('passageiro');
        $auth->add($passageiro);

        // adciona a role "motorista"
        $motorista = $auth->createRole('motorista');
        $auth->add($motorista);

        // adciona a role "admin" e adicionar childs para ter as mesmas permissoes que as childs
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin , $passageiro);
        $auth->addChild($admin , $motorista);



    }
}