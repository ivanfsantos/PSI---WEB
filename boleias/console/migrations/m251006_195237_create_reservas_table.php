<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reservas}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%perfis}}`
 * - `{{%viaturas}}`
 */
class m251006_195237_create_reservas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reservas}}', [
            'id' => $this->primaryKey(),
            'estado' => $this->string(20)->notNull(),
            'perfil_id' => $this->integer()->notNull(),
            'boleia_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        // creates index for column `perfil_id`
        $this->createIndex(
            '{{%idx-reservas-perfil_id}}',
            '{{%reservas}}',
            'perfil_id'
        );

        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-reservas-perfil_id}}',
            '{{%reservas}}',
            'perfil_id',
            '{{%perfis}}',
            'id',
            'CASCADE'
        );

        // creates index for column `boleia_id`
        $this->createIndex(
            '{{%idx-reservas-boleia_id}}',
            '{{%reservas}}',
            'boleia_id'
        );

        // add foreign key for table `{{%boleias}}`
        $this->addForeignKey(
            '{{%fk-reservas-boleia_id}}',
            '{{%reservas}}',
            'boleia_id',
            '{{%boleias}}',
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
            '{{%fk-reservas-perfil_id}}',
            '{{%reservas}}'
        );

        // drops index for column `perfil_id`
        $this->dropIndex(
            '{{%idx-reservas-perfil_id}}',
            '{{%reservas}}'
        );

        // drops foreign key for table `{{%boleias}}`
        $this->dropForeignKey(
            '{{%fk-reservas-boleia_id}}',
            '{{%reservas}}'
        );

        // drops index for column `boleia_id`
        $this->dropIndex(
            '{{%idx-reservas-boleia_id}}',
            '{{%reservas}}'
        );

        $this->dropTable('{{%reservas}}');
    }
}
