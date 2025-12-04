<?php

use yii\db\Migration;

class m251118_203133_add_perfil_id_to_favoritos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('destinos_favoritos', 'perfil_id', $this->integer()->notNull());

        $this->addForeignKey(
            'fk_favoritos_perfil',
            'destinos_favoritos',
            'perfil_id',
            'perfis',
            'id',
            'CASCADE'
        );

        $this->dropForeignKey(
            '{{%fk-destinos_favoritos-boleia_id}}',
            '{{%destinos_favoritos}}'
        );

        // drops index for column `boleia_id`
        $this->dropIndex(
            '{{%idx-destinos_favoritos-boleia_id}}',
            '{{%destinos_favoritos}}'
        );
        $this->dropColumn('destinos_favoritos', 'boleia_id');

        $this->addColumn('destinos_favoritos','tipo','ENUM("origem", "destino") NOT NULL DEFAULT "origem"');
        $this->addColumn('destinos_favoritos','endereco',$this->string(255)->notNull());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_favoritos_perfil', 'destinos_favoritos');
        $this->dropColumn('destinos_favoritos', 'perfil_id');

        echo "m251118_203133_add_perfil_id_to_favoritos cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251118_203133_add_perfil_id_to_favoritos cannot be reverted.\n";

        return false;
    }
    */
}
