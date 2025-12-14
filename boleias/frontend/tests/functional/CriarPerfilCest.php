<?php

declare(strict_types=1);


namespace frontend\tests\Functional;

use common\models\User;
use frontend\tests\FunctionalTester;
use Yii;

final class CriarPerfilCest
{
    public function _before(FunctionalTester $I): void
    {
        $this->user = new User();
        $this->user->username = 'user_teste';
        $this->user->email = 'user@teste.com';
        $this->user->setPassword('123456');
        $this->user->generateAuthKey();
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->save(false);
    }

    public function tryToTest(FunctionalTester $I): void
    {
        $I->amLoggedInAs($this->user);
        $I->amOnPage('/perfil/create');

        $I->fillField('Perfil[nome]', 'Teste Funcional');
        $I->fillField('Perfil[telefone]', '912345678');
        $I->fillField('Perfil[morada]', 'Rua Teste, 123');
        $I->fillField('Perfil[genero]', 'Masculino');
        $I->fillField('Perfil[data_nascimento]', '1990-01-01');

        $I->click('Save');

        $I->see('Perfil criado com sucesso!');
    }

    public function _after()
    {
        Yii::$app->db->transaction->rollBack();
    }

}
