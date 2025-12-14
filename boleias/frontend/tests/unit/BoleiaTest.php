<?php

namespace common\tests\unit;

use common\models\User;
use common\models\Perfil;
use common\models\Documento;
use common\models\Viatura;
use common\models\Boleia;
use Codeception\Test\Unit;
use Yii;

class BoleiaTest extends Unit
{
    private $user;
    private $perfil;
    private $viatura;

    protected function _before()
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

    protected function _after()
    {
        Yii::$app->db->transaction->rollBack();
    }

    public function testCriarBoleia()
    {
        $boleia = new Boleia();
        $boleia->viatura_id = $this->viatura->id;
        $boleia->origem = 'Porto';
        $boleia->destino = 'Lisboa';
        $boleia->data_hora = date('Y-m-d H:i:s', strtotime('+1 day'));
        $boleia->lugares_disponiveis = 3;
        $boleia->preco = 25.50;

        $this->assertTrue($boleia->save(), json_encode($boleia->errors));

        $this->assertEquals($this->viatura->id, $boleia->viatura->id);
    }
}
