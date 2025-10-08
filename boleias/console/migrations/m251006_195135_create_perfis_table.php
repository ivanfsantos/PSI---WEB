<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%perfis}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m251006_195135_create_perfis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%perfis}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(30)->notNull(),
            'telefone' => $this->integer()->notNull(),
            'morada' => $this->string(50)->notNull(),
            'genero' => $this->string(30)->notNull(),
            'data_nascimento' => $this->date()->notNull(),
            'condutor' => $this->boolean()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-perfis-user_id}}',
            '{{%perfis}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-perfis-user_id}}',
            '{{%perfis}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-perfis-user_id}}',
            '{{%perfis}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-perfis-user_id}}',
            '{{%perfis}}'
        );

        $this->dropTable('{{%perfis}}');
    }
}
