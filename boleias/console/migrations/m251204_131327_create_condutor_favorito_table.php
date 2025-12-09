<?php

use yii\db\Migration;

class m251204_131327_create_condutor_favorito_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%condutor_favorito}}', [
            'id' => $this->primaryKey(),
            'passageiro_id' => $this->integer()->notNull(),
            'condutor_id' => $this->integer()->notNull(),
        ]);

        // Evita duplicados
        $this->createIndex(
            'ux_condutor_favorito_passageiro_condutor',
            '{{%condutor_favorito}}',
            ['passageiro_id', 'condutor_id'],
            true
        );

        // Índices para performance
        $this->createIndex('ix_condutor_favorito_passageiro', '{{%condutor_favorito}}', 'passageiro_id');
        $this->createIndex('ix_condutor_favorito_condutor', '{{%condutor_favorito}}', 'condutor_id');

        // FKs (assumindo que tens tabela perfil com PK id)
        $this->addForeignKey(
            'fk_condutor_favorito_passageiro',
            '{{%condutor_favorito}}',
            'passageiro_id',
            '{{%perfis}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_condutor_favorito_condutor',
            '{{%condutor_favorito}}',
            'condutor_id',
            '{{%perfis}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_condutor_favorito_passageiro', '{{%condutor_favorito}}');
        $this->dropForeignKey('fk_condutor_favorito_condutor', '{{%condutor_favorito}}');
        $this->dropTable('{{%condutor_favorito}}');
    }
}
