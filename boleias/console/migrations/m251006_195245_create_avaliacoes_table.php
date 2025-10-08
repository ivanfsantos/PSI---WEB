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
            'rating' => $this->integer()->notNull(),
            'boleia_id'=> $this->integer()->notNull(),
            'perfil_id'=> $this->integer()->notNull(),

        ], 'ENGINE=InnoDB');

        // creates index for column `boleia_id`
        $this->createIndex(
            '{{%idx-avaliacoes-boleia_id}}',
            '{{%avaliacoes}}',
            'boleia_id'
        );

        // add foreign key for table `{{%boleias}}`
        $this->addForeignKey(
            '{{%fk-avaliacoes-boleia_id}}',
            '{{%avaliacoes}}',
            'boleia_id',
            '{{%boleias}}',
            'id',
            'CASCADE'
        );



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
        // drops foreign key for table `{{%boleias}}`
        $this->dropForeignKey(
            '{{%fk-avaliacoes-boleia_id}}',
            '{{%avaliacoes}}'
        );

        // drops index for column `boleia_id`
        $this->dropIndex(
            '{{%idx-avaliacoes-boleia_id}}',
            '{{%avaliacoes}}'
        );

        $this->dropTable('{{%avaliacoes}}');
    }
}
