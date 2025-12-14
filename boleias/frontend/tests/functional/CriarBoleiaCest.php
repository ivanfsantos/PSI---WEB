<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use common\models\User;
use common\models\Documento;
use common\models\Perfil;
use common\models\Viatura;
use frontend\tests\FunctionalTester;
use Yii;

final class CriarBoleiaCest
{
    private User $user;
    private Perfil $perfil;
    private Viatura $viatura;

    public function _before(): void
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
        $criarBoleia = $auth->getPermission('criarBoleia');
        if (!$criarBoleia) {
            $criarBoleia = $auth->createPermission('criarBoleia');
            $criarBoleia->description = 'Permite criar boleias';
            $auth->add($criarBoleia);
        }
        $auth->assign($criarBoleia, $this->user->id);


        $this->perfil = new Perfil();
        $this->perfil->user_id = $this->user->id;
        $this->perfil->nome = 'Condutor Teste';
        $this->perfil->telefone = 912345678;
        $this->perfil->morada = 'Rua Teste, 123';
        $this->perfil->genero = 'M';
        $this->perfil->data_nascimento = '1990-01-01';
        $this->perfil->condutor = 1;
        $this->perfil->save(false);

        $doc = new Documento();
        $doc->perfil_id = $this->perfil->id;
        $doc->valido = 1;
        $doc->carta_conducao = 'carta.pdf';
        $doc->cartao_cidadao = 'cc.pdf';
        $doc->save(false);

        $this->viatura = new Viatura();
        $this->viatura->perfil_id = $this->perfil->id;
        $this->viatura->marca = 'Tesla';
        $this->viatura->modelo = 'Model 3';
        $this->viatura->matricula = 'AA-00-BB';
        $this->viatura->cor = 'Branco';
        $this->viatura->save(false);

    }

    public function criarBoleiaComSucesso(FunctionalTester $I): void
    {
        $I->amLoggedInAs($this->user);
        $I->amOnPage('/site/create');

        $I->fillField('Boleia[origem]', 'Porto');
        $I->fillField('Boleia[destino]', 'Lisboa');
        $I->fillField('Boleia[data_hora]', date('Y-m-d H:i:s', strtotime('+1 day')));
        $I->fillField('Boleia[lugares_disponiveis]', 3);
        $I->selectOption('Boleia[viatura_id]', (string)$this->viatura->id);
        $I->fillField('Boleia[preco]', 25.50);

        $I->click('Save');
        $I->see('Boleia criada com sucesso!');

    }

    public function _after()
    {
        Yii::$app->db->transaction->rollBack();
    }

}
