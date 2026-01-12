<?php

namespace common\tests\unit;

use common\models\User;
use common\models\Perfil;
use common\models\Documento;
use common\models\Viatura;
use common\models\Boleia;
use common\models\Reserva;
use Codeception\Test\Unit;
use Yii;

class ReservaTest extends Unit
{
    private $user;
    private $perfil;
    private $viatura;
    private $boleia;

    protected function _before()
    {
        Yii::$app->db->beginTransaction();

        $this->user = new User();
        $this->user->username = 'user_teste';
        $this->user->email = 'user@teste.com';
        $this->user->setPassword('123456');
        $this->user->generateAuthKey();
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->save(false);

        $this->perfil = new Perfil();
        $this->perfil->user_id = $this->user->id;
        $this->perfil->nome = 'Perfil Teste';
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

        $this->boleia = new Boleia();
        $this->boleia->viatura_id = $this->viatura->id;
        $this->boleia->origem = 'Porto';
        $this->boleia->destino = 'Lisboa';
        $this->boleia->data_hora = date('Y-m-d H:i:s', strtotime('+1 day'));
        $this->boleia->lugares_disponiveis = 3;
        $this->boleia->preco = 25.50;
        $this->boleia->save(false);
    }

    protected function _after()
    {
        Yii::$app->db->transaction->rollBack();
    }

    public function testCriarReserva()
    {
        $reserva = new Reserva();
        $reserva->perfil_id = $this->perfil->id;
        $reserva->boleia_id = $this->boleia->id;
        $reserva->ponto_encontro = 'Praça Teste';
        $reserva->contacto = '912345678';
        $reserva->reembolso = 0;

        $this->assertTrue($reserva->save(), json_encode($reserva->errors));
        $this->assertEquals($this->boleia->id, $reserva->boleia->id);
        $this->assertEquals($this->perfil->id, $reserva->perfil->id);
    }

    public function testAtualizarReserva()
    {
        $reserva = new Reserva();
        $reserva->perfil_id = $this->perfil->id;
        $reserva->boleia_id = $this->boleia->id;
        $reserva->ponto_encontro = 'Praça Teste';
        $reserva->contacto = '912345678';
        $reserva->reembolso = 0;

        $this->assertTrue($reserva->save(), json_encode($reserva->errors));


        $reserva->ponto_encontro = 'Estação Central';
        $reserva->contacto = '987654321';
        $reserva->reembolso = 1;

        $this->assertTrue($reserva->save(), json_encode($reserva->errors));


        $reservaAtualizada = Reserva::findOne($reserva->id);


        $this->assertEquals('Estação Central', $reservaAtualizada->ponto_encontro);
        $this->assertEquals('987654321', $reservaAtualizada->contacto);
        $this->assertEquals(1, $reservaAtualizada->reembolso);
    }

    public function testEliminarReserva()
    {
        // 1️⃣ Criar reserva
        $reserva = new Reserva();
        $reserva->perfil_id = $this->perfil->id;
        $reserva->boleia_id = $this->boleia->id;
        $reserva->ponto_encontro = 'Praça Teste';
        $reserva->contacto = '912345678';
        $reserva->reembolso = 0;

        $this->assertTrue($reserva->save(), json_encode($reserva->errors));

        $id = $reserva->id;

        $this->assertEquals(1, $reserva->delete());


        $this->assertNull(Reserva::findOne($id));
    }

    public function testNaoUltrapassaLugaresDisponiveis()
    {
        for ($i = 0; $i < 3; $i++) {
            $reserva = new Reserva();
            $reserva->perfil_id = $this->perfil->id;
            $reserva->boleia_id = $this->boleia->id;
            $reserva->ponto_encontro = 'Ponto ' . $i;
            $reserva->contacto = '912345678';
            $reserva->reembolso = 0;

            $this->assertTrue(
                $reserva->save(),
                'Falhou na reserva ' . ($i + 1)
            );
        }

        $reservaExtra = new Reserva();
        $reservaExtra->perfil_id = $this->perfil->id;
        $reservaExtra->boleia_id = $this->boleia->id;
        $reservaExtra->ponto_encontro = 'Reserva Extra';
        $reservaExtra->contacto = '912345678';
        $reservaExtra->reembolso = 0;

        $this->assertFalse($reservaExtra->save());


        $this->assertArrayHasKey('boleia_id', $reservaExtra->errors);
    }



}
