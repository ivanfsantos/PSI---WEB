<?php

use yii\db\Migration;

class m251118_212402_remove_perfil_id_tabela_destinos_favoritos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('destinos_favoritos', 'boleia_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {


        echo "m251118_212402_remove_perfil_id_tabela_destinos_favoritos cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251118_212402_remove_perfil_id_tabela_destinos_favoritos cannot be reverted.\n";

        return false;
    }
    */
}
