<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rotas_favoritas}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%boleias}}`
 */
class m251006_195315_create_destinos_favoritos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destinos_favoritos}}', [
            'id' => $this->primaryKey(),
            'boleia_id' => $this->integer(),
            'perfil_id' => $this->integer(),
        ], 'ENGINE=InnoDB');

        // creates index for column `boleia_id`
        $this->createIndex(
            '{{%idx-destinos_favoritos-boleia_id}}',
            '{{%destinos_favoritos}}',
            'boleia_id'
        );

        // add foreign key for table `{{%boleias}}`
        $this->addForeignKey(
            '{{%fk-destinos_favoritos-boleia_id}}',
            '{{%destinos_favoritos}}',
            'boleia_id',
            '{{%boleias}}',
            'id',
            'CASCADE'
        );

        // creates index for column `perfil_id`
        $this->createIndex(
            '{{%idx-destinos_favoritos-perfil_id}}',
            '{{%destinos_favoritos}}',
            'perfil_id'
        );


        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-destinos_favoritos-perfil_id}}',
            '{{%destinos_favoritos}}',
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
            '{{%fk-destinos_favoritos-boleia_id}}',
            '{{%destinos_favoritos}}'
        );

        // drops index for column `boleia_id`
        $this->dropIndex(
            '{{%idx-destinos_favoritos-boleia_id}}',
            '{{%destinos_favoritos}}'
        );

        $this->dropForeignKey(
            '{{%fk-destinos_favoritos-perfil_id}}',
            '{{%destinos_favoritos}}'
        );

        $this->dropIndex(
            '{{%idx-destinos_favoritos-perfil_id}}',
            '{{%destinos_favoritos}}'
        );


        $this->dropTable('{{%destinos_favoritos}}');
    }
}
