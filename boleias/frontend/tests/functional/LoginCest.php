<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\models\User;

class LoginCest
{
    private $user;

    public function _before(FunctionalTester $I)
    {
        $this->user = new User();
        $this->user->username = 'user_teste';
        $this->user->email = 'user@teste.com';
        $this->user->setPassword('123456');
        $this->user->generateAuthKey();
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->save(false);
    }

    public function _after(FunctionalTester $I)
    {
        $this->user->delete();
    }

    public function loginComSucesso(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');

        $I->submitForm('#login-form', [
            'LoginForm[username]' => $this->user->username,
            'LoginForm[password]' => '123456',
        ]);

        $I->seeInCurrentUrl('/');
        $I->see('Logout');
    }

    public function loginFalha(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');

        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'user_errado',
            'LoginForm[password]' => 'senha_errada',
        ]);

        $I->see('Incorrect username or password.');
    }


}
