<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%documentos}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%perfis}}`
 */
class m251006_195258_create_documentos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%documentos}}', [
            'id' => $this->primaryKey(),
            'carta_conducao' => $this->string(255),
            'cartao_cidadao' => $this->string(255),
            'perfil_id' => $this->integer(),
        ], 'ENGINE=InnoDB');

        // creates index for column `perfil_id`
        $this->createIndex(
            '{{%idx-documentos-perfil_id}}',
            '{{%documentos}}',
            'perfil_id'
        );

        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-documentos-perfil_id}}',
            '{{%documentos}}',
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
        // drops foreign key for table `{{%perfis}}`
        $this->dropForeignKey(
            '{{%fk-documentos-perfil_id}}',
            '{{%documentos}}'
        );

        // drops index for column `perfil_id`
        $this->dropIndex(
            '{{%idx-documentos-perfil_id}}',
            '{{%documentos}}'
        );

        $this->dropTable('{{%documentos}}');
    }
}
