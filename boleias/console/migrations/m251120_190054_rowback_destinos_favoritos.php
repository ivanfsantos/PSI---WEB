<?php

use yii\db\Migration;

class m251120_190054_rowback_destinos_favoritos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('destinos_favoritos', 'tipo');
        $this->dropColumn('destinos_favoritos', 'endereco');

        $this->addColumn('destinos_favoritos', 'boleia_id', $this->integer());

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


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251120_190054_rowback_destinos_favoritos cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251120_190054_rowback_destinos_favoritos cannot be reverted.\n";

        return false;
    }
    */
}
