<?php

namespace frontend\tests\unit;

use common\models\User;
use common\models\Viatura;
use common\models\Perfil;
use frontend\tests\UnitTester;

class ViaturaTest extends \Codeception\Test\Unit
{
    protected $tester;

    protected function _before()
    {
        $this->user = new User();
        $this->user->username = 'condutor_teste';
        $this->user->email = 'condutor@teste.com';
        $this->user->setPassword('123456');
        $this->user->generateAuthKey();
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->save(false);

        $this->perfil = new Perfil();
        $this->perfil->user_id = $this->user->id;
        $this->perfil->nome = 'Condutor Teste';
        $this->perfil->telefone = 912345678;
        $this->perfil->morada = 'Rua Teste, 123';
        $this->perfil->genero = 'M';
        $this->perfil->data_nascimento = '1990-01-01';
        $this->perfil->condutor = 1;
        $this->perfil->save(false);
    }

    public function testCriarViatura()
    {
        $viatura = new Viatura();
        $viatura->perfil_id = $this->perfil->id; // depende do Perfil do _before()
        $viatura->marca = 'Toyota';
        $viatura->modelo = 'Corolla';
        $viatura->matricula = 'AB-12-CD';
        $viatura->cor = 'Prata';

        $this->assertTrue($viatura->save(), json_encode($viatura->errors));

    }
}
