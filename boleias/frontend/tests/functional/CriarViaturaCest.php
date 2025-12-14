<?php

declare(strict_types=1);


namespace frontend\tests\Functional;

use common\models\Perfil;
use common\models\User;
use frontend\tests\FunctionalTester;
use Yii;

final class CriarViaturaCest
{
    public function _before(FunctionalTester $I): void
    {
        Yii::$app->db->beginTransaction();

        $this->user = new User();
        $this->user->username = 'condutor_teste';
        $this->user->email = 'condutor@teste.com';
        $this->user->setPassword('123456');
        $this->user->generateAuthKey();
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->save(false);

        $auth = Yii::$app->authManager;


        $this->perfil = new Perfil();
        $this->perfil->user_id = $this->user->id;
        $this->perfil->nome = 'Condutor Teste';
        $this->perfil->telefone = 912345678;
        $this->perfil->morada = 'Rua Teste, 123';
        $this->perfil->genero = 'M';
        $this->perfil->data_nascimento = '1990-01-01';
        $this->perfil->condutor = 1;
        $this->perfil->save(false);


        $criarViatura = $auth->getPermission('acederViatura');
        if (!$criarViatura) {
            $criarViatura = $auth->createPermission('acederViatura');
            $criarViatura->description = 'Permite criar viaturas';
            $auth->add($criarViatura);
        }
        $auth->assign($criarViatura, $this->user->id);
    }

    public function tryToTest(FunctionalTester $I): void
    {
        $I->amLoggedInAs($this->user);

        $I->amOnPage('/viatura/create?id=' . $this->perfil->id);

        $I->fillField('Viatura[marca]', 'Tesla');
        $I->fillField('Viatura[modelo]', 'Model S');
        $I->fillField('Viatura[matricula]', 'AA-11-BB');
        $I->fillField('Viatura[cor]', 'Preto');

        $I->click('Save');

       // $I->see('Viatura criada com sucesso!');
    }


    public function _after()
    {
        Yii::$app->db->transaction->rollBack();
    }

}
