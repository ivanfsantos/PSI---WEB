<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class BoleiaCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function postBoleiaEndpoints(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        // login via fixture user (session-based) so controller sees Yii::$app->user->identity
        $I->fillField('Username', 'erau');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');
        $I->see('Logout (erau)');

        $data = [
            'origem' => 'Louriçal',
            'destino' => 'ola',
            'data_hora' => '2025-11-20 20:50:00',
            'lugares_disponiveis' => 3,
            'preco' => 50.00,
            'viatura_id' => 2,
        ];

        // test the pretty URL no-trailing-slash
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/api/boleia', $data);
        $I->dontSeeResponseContains('Method Not Allowed');

        // test pretty URL with trailing slash
        $I->sendPOST('/api/boleia/', $data);
        $I->dontSeeResponseContains('Method Not Allowed');

        // test plural
        $I->sendPOST('/api/boleias', $data);
        $I->dontSeeResponseContains('Method Not Allowed');

        // test direct index.php route fallback (always should work)
        $I->sendPOST('/index.php?r=api%2Fboleia%2Fcreate', $data);
        $I->dontSeeResponseContains('Method Not Allowed');
    }
}
