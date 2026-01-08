<?php

declare(strict_types=1);

namespace frontend\tests\Functional;

use common\models\Tarefa;
use common\models\User;
use frontend\tests\FunctionalTester;
use Yii;

final class TarefaCest
{
    private ?User $user = null;

    /**
     * Antes de cada teste: cria um usuário e faz login
     */
    public function _before(FunctionalTester $I): void
    {
        // Cria usuário de teste
        $this->user = new User([
            'username' => 'teste',
            'email' => 'teste@example.com',
        ]);
        $this->user->setPassword('123456');
        $this->user->generateAuthKey();
        $this->user->save(false);

        // Faz login
        $I->amLoggedInAs($this->user->id);
    }

    /**
     * Teste principal: criar tarefa, acessar index, atualizar estado
     */
    public function testTarefaFlow(FunctionalTester $I): void
    {
        // Cria uma tarefa
        $tarefa = new Tarefa([
            'titulo' => 'Tarefa de teste',
            'criador' => $this->user->id,
            'atribuido' => $this->user->id,
        ]);
        $tarefa->save(false);

        // Acessa página de tarefas
        $I->amOnPage("/index.php?r=tarefa/index&id={$this->user->id}");
        $I->see('Tarefas');
        $I->see($tarefa->titulo);

        // Atualiza o estado via formulário
        $I->submitForm(
            "form[action='/tarefa/update-estado?id={$tarefa->id}']",
            ['estado' => Tarefa::ESTADO_FEITO]
        );

        // Verifica redirecionamento
        $I->seeCurrentUrlEquals("/tarefa/index?id={$this->user->id}");

        // Verifica banco de dados
        $tarefa->refresh();
        $I->assertEquals(Tarefa::ESTADO_FEITO, $tarefa->estado);
    }

    /**
     * Depois de cada teste: remove usuário e tarefas
     */
    public function _after(FunctionalTester $I): void
    {
        // Remove tarefas do usuário de teste
        Tarefa::deleteAll(['criador' => $this->user->id]);
        // Remove usuário de teste
        if ($this->user) {
            $this->user->delete();
        }

        // Se estiver usando transaction global, você pode usar rollback
        if (Yii::$app->db->transaction) {
            Yii::$app->db->transaction->rollBack();
        }
    }
}
