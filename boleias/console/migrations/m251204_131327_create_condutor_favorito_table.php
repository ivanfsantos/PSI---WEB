<?php

use yii\db\Migration;

class m251204_131327_create_condutor_favorito_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%condutores_favoritos}}', [
            'id' => $this->primaryKey(),
            'perfil_id_user' => $this->integer()->notNull(),
            'perfil_id_condutor' => $this->integer()->notNull(),

        ], 'ENGINE=InnoDB');

        $this->createIndex(
            '{{%idx-condutores_favoritos-perfil_id_user}}',
            '{{%condutores_favoritos}}',
            'perfil_id_user'
        );
        $this->addForeignKey(
            '{{%fk-condutores_favoritos-perfil_id_user}}',
            '{{%condutores_favoritos}}',
            'perfil_id_user',
            '{{%perfis}}',
            'id',
            'CASCADE'
        );

        // index e fk para condutor favoritado
        $this->createIndex(
            '{{%idx-condutores_favoritos-perfil_id_condutor}}',
            '{{%condutores_favoritos}}',
            'perfil_id_condutor'
        );
        $this->addForeignKey(
            '{{%fk-condutores_favoritos-perfil_id_condutor}}',
            '{{%condutores_favoritos}}',
            'perfil_id_condutor',
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
        $this->dropTable('{{%condutores_favoritos}}');
    }
}
