<?php

declare(strict_types=1);


namespace frontend\tests\Functional;

use common\models\Boleia;
use common\models\Documento;
use common\models\Perfil;
use common\models\User;
use common\models\Viatura;
use frontend\tests\FunctionalTester;
use Yii;

final class CriarReservaCest
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


        $this->perfil = new Perfil();
        $this->perfil->user_id = $this->user->id;
        $this->perfil->nome = 'Passageiro Teste';
        $this->perfil->telefone = 912345678;
        $this->perfil->morada = 'Rua Teste, 123';
        $this->perfil->genero = 'M';
        $this->perfil->data_nascimento = '1990-01-01';
        $this->perfil->condutor = 0;
        $this->perfil->save(false);

        $auth = Yii::$app->authManager;

        $criarReserva = $auth->getPermission('acederReservas');
        if (!$criarReserva) {
            $criarReserva = $auth->createPermission('acederReservas');
            $criarReserva->description = 'Permite criar Reservas';
            $auth->add($criarReserva);
        }
        $auth->assign($criarReserva, $this->user->id);

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

        $this->boleia = new Boleia();
        $this->boleia->viatura_id = $this->viatura->id;
        $this->boleia->origem = 'Porto';
        $this->boleia->destino = 'Lisboa';
        $this->boleia->data_hora = date('Y-m-d H:i:s', strtotime('+1 day'));
        $this->boleia->lugares_disponiveis = 3;
        $this->boleia->preco = 25.50;
        $this->boleia->save(false);

    }

    public function tryToTest(FunctionalTester $I): void
    {
        $I->amLoggedInAs($this->user);
        $I->amOnPage('/reserva/create?id=' . $this->boleia->id);

        $I->fillField('Reserva[ponto_encontro]', 'Rotunda');
        $I->fillField('Reserva[contacto]', '912345678');

        $I->click('Save');
    }
}
