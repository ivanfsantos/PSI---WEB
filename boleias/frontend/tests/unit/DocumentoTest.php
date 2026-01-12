<?php


namespace frontend\tests\Unit;

use common\models\Documento;
use common\models\Perfil;
use common\models\User;
use frontend\tests\UnitTester;

class DocumentoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

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

    public function testCriarDocumento()
    {
        $documento = new Documento();
        $documento->perfil_id = $this->perfil->id;
        $documento->carta_conducao = 'carta.pdf';
        $documento->cartao_cidadao = 'cc.pdf';
        $documento->valido = 1;

        $this->assertTrue($documento->save(), json_encode($documento->errors));
    }

    public function testEliminarDocumento()
    {
        $documento = new Documento();
        $documento->perfil_id = $this->perfil->id;
        $documento->carta_conducao = 'carta.pdf';
        $documento->cartao_cidadao = 'cc.pdf';
        $documento->valido = 1;

        $this->assertTrue($documento->save(), json_encode($documento->errors));

        $id = $documento->id;

        $this->assertEquals(1, $documento->delete());


        $this->assertNull(Documento::findOne($id));
    }
}
