<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mensagens}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%perfis}}`
 * - `{{%perfis}}`
 */
class m251006_195309_create_mensagens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mensagens}}', [
            'id' => $this->primaryKey(),
            'mensagem' => $this->text(),
            'remetente_id' => $this->integer(),
            'destinatario_id' => $this->integer(),
        ], 'ENGINE=InnoDB');

        // creates index for column `remetente_id`
        $this->createIndex(
            '{{%idx-mensagens-remetente_id}}',
            '{{%mensagens}}',
            'remetente_id'
        );

        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-mensagens-remetente_id}}',
            '{{%mensagens}}',
            'remetente_id',
            '{{%perfis}}',
            'id',
            'CASCADE'
        );

        // creates index for column `destinatario_id`
        $this->createIndex(
            '{{%idx-mensagens-destinatario_id}}',
            '{{%mensagens}}',
            'destinatario_id'
        );

        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-mensagens-destinatario_id}}',
            '{{%mensagens}}',
            'destinatario_id',
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
        // drops foreign key for table `{{%perfis}}`
        $this->dropForeignKey(
            '{{%fk-mensagens-remetente_id}}',
            '{{%mensagens}}'
        );

        // drops index for column `remetente_id`
        $this->dropIndex(
            '{{%idx-mensagens-remetente_id}}',
            '{{%mensagens}}'
        );

        // drops foreign key for table `{{%perfis}}`
        $this->dropForeignKey(
            '{{%fk-mensagens-destinatario_id}}',
            '{{%mensagens}}'
        );

        // drops index for column `destinatario_id`
        $this->dropIndex(
            '{{%idx-mensagens-destinatario_id}}',
            '{{%mensagens}}'
        );

        $this->dropTable('{{%mensagens}}');
    }
}
