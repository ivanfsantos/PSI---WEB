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

    public function testAtualizarBoleia()
    {
        $boleia = new Boleia();
        $boleia->viatura_id = $this->viatura->id;
        $boleia->origem = 'Porto';
        $boleia->destino = 'Lisboa';
        $boleia->data_hora = date('Y-m-d H:i:s', strtotime('+1 day'));
        $boleia->lugares_disponiveis = 3;
        $boleia->preco = 25.50;

        $this->assertTrue($boleia->save(), json_encode($boleia->errors));


        $boleia->destino = 'Coimbra';
        $boleia->lugares_disponiveis = 2;
        $boleia->preco = 20.00;

        $this->assertTrue($boleia->save(), json_encode($boleia->errors));

        $boleiaAtualizada = Boleia::findOne($boleia->id);

        $this->assertEquals('Coimbra', $boleiaAtualizada->destino);
        $this->assertEquals(2, $boleiaAtualizada->lugares_disponiveis);
        $this->assertEquals(20.00, $boleiaAtualizada->preco);
    }

    public function testEliminarBoleia()
    {
        $boleia = new Boleia();
        $boleia->viatura_id = $this->viatura->id;
        $boleia->origem = 'Porto';
        $boleia->destino = 'Lisboa';
        $boleia->data_hora = date('Y-m-d H:i:s', strtotime('+1 day'));
        $boleia->lugares_disponiveis = 3;
        $boleia->preco = 25.50;

        $this->assertTrue($boleia->save(), json_encode($boleia->errors));

        $id = $boleia->id;

        $this->assertEquals(1, $boleia->delete());


        $this->assertNull(Boleia::findOne($id));
    }

    public function testNaoCondutorPodeCriarBoleia()
    {
        // Perfil que nao é condutor condutor
        $user2 = new User();
        $user2->username = 'nao_condutor';
        $user2->email = 'nao_condutor@teste.com';
        $user2->setPassword('123456');
        $user2->generateAuthKey();
        $user2->status = User::STATUS_ACTIVE;
        $user2->save(false);

        $perfilNaoCondutor = new Perfil();
        $perfilNaoCondutor->user_id = $user2->id;
        $perfilNaoCondutor->nome = 'Não Condutor';
        $perfilNaoCondutor->telefone = 912345679;
        $perfilNaoCondutor->morada = 'Rua Teste 2';
        $perfilNaoCondutor->genero = 'F';
        $perfilNaoCondutor->data_nascimento = '1995-01-01';
        $perfilNaoCondutor->condutor = 0;
        $perfilNaoCondutor->save(false);

        // Cria uma viatura do perfil nao condutor
        $viaturaNaoCondutor = new Viatura();
        $viaturaNaoCondutor->perfil_id = $perfilNaoCondutor->id;
        $viaturaNaoCondutor->marca = 'Ford';
        $viaturaNaoCondutor->modelo = 'Fiesta';
        $viaturaNaoCondutor->matricula = 'CC-11-DD';
        $viaturaNaoCondutor->cor = 'Vermelho';
        $viaturaNaoCondutor->save(false);

        // Tenta criar uma boleia com viatura de não condutor
        $boleia = new Boleia();
        $boleia->viatura_id = $viaturaNaoCondutor->id;
        $boleia->origem = 'Lisboa';
        $boleia->destino = 'Porto';
        $boleia->data_hora = date('Y-m-d H:i:s', strtotime('+1 day'));
        $boleia->lugares_disponiveis = 3;
        $boleia->preco = 15.00;

        $this->assertFalse($boleia->save());
        $this->assertArrayHasKey('viatura_id', $boleia->errors);
    }





}
