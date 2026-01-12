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

    public function testNaoCondutorNaoPodeEnviarDocumentoDeCondutor()
    {
        $user = new User();
        $user->username = 'nao_condutor_doc';
        $user->email = 'nao_condutor_doc@teste.com';
        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save(false);

        $perfilNaoCondutor = new Perfil();
        $perfilNaoCondutor->user_id = $user->id;
        $perfilNaoCondutor->nome = 'Não Condutor';
        $perfilNaoCondutor->telefone = 912345680;
        $perfilNaoCondutor->morada = 'Rua Teste 3';
        $perfilNaoCondutor->genero = 'M';
        $perfilNaoCondutor->data_nascimento = '1995-01-01';
        $perfilNaoCondutor->condutor = 0;
        $perfilNaoCondutor->save(false);

        $doc = new Documento();
        $doc->perfil_id = $perfilNaoCondutor->id;
        $doc->valido = 1;
        $doc->carta_conducao = 'carta.pdf'; 
        $doc->cartao_cidadao = 'cc.pdf';


        $this->assertFalse($doc->save());
        $this->assertArrayHasKey('carta_conducao', $doc->errors);
    }

}
