<?php


namespace frontend\tests\Unit;

use common\models\Perfil;
use common\models\User;
use frontend\tests\UnitTester;
use Yii;

class PerfilTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

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
    }

    public function testCriarPerfil()
    {
        $perfil = new Perfil();
        $perfil->user_id = $this->user->id;
        $perfil->nome = 'João Teste';
        $perfil->telefone = 912345678;
        $perfil->morada = 'Rua Teste, 456';
        $perfil->genero = 'M';
        $perfil->data_nascimento = '1992-05-01';
        $perfil->condutor = 1;

        $this->assertTrue($perfil->save(), json_encode($perfil->errors));
    }

    public function testAtualizarPerfil()
    {
        $perfil = new Perfil();
        $perfil->user_id = $this->user->id;
        $perfil->nome = 'João Teste';
        $perfil->telefone = 912345678;
        $perfil->morada = 'Rua Teste, 456';
        $perfil->genero = 'M';
        $perfil->data_nascimento = '1992-05-01';
        $perfil->condutor = 1;

        $this->assertTrue($perfil->save(), json_encode($perfil->errors));

        $perfil->nome = 'António Mendes';
        $perfil->telefone = 985267852;
        $perfil->genero = 'F';

        $this->assertTrue($perfil->save(), json_encode($perfil->errors));

        $perfilAtualizada = Perfil::findOne($perfil->id);

        $this->assertEquals('António Mendes', $perfilAtualizada->nome);
        $this->assertEquals(985267852, $perfilAtualizada->telefone);
        $this->assertEquals('F', $perfilAtualizada->genero);
    }

    public function testEliminarBoleia()
    {
        $perfil = new Perfil();
        $perfil->user_id = $this->user->id;
        $perfil->nome = 'João Teste';
        $perfil->telefone = 912345678;
        $perfil->morada = 'Rua Teste, 456';
        $perfil->genero = 'M';
        $perfil->data_nascimento = '1992-05-01';
        $perfil->condutor = 1;

        $this->assertTrue($perfil->save(), json_encode($perfil->errors));

        $id = $perfil->id;

        $this->assertEquals(1, $perfil->delete());


        $this->assertNull(Perfil::findOne($id));
    }
}
