<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%avaliacoes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%boleias}}`
 */
class m251006_195245_create_avaliacoes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%avaliacoes}}', [
            'id' => $this->primaryKey(),
            'descricao' => $this->text()->notNull(),
            'perfil_id'=> $this->integer()->notNull(),

        ], 'ENGINE=InnoDB');


        // creates index for column `perfil_id`
        $this->createIndex(
            '{{%idx-avaliacoes-perfil_id}}',
            '{{%avaliacoes}}',
            'perfil_id'
        );

        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-avaliacoes-perfil_id}}',
            '{{%avaliacoes}}',
            'perfil_id',
            '{{%perfis}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%avaliacoes}}');
    }
}
