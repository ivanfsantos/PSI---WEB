<?php

use yii\db\Migration;

class m251202_204832_fix_boleia_id_obrigatorio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-destinos_favoritos-boleia_id',
            'destinos_favoritos'
        );

        // 2. Remover índice antigo
        $this->dropIndex(
            'idx-destinos_favoritos-boleia_id',
            'destinos_favoritos'
        );

        // 3. Remover valores inválidos
        $this->delete('destinos_favoritos', 'boleia_id IS NULL');

        // 4. Tornar boleia_id NOT NULL
        $this->alterColumn(
            'destinos_favoritos',
            'boleia_id',
            $this->integer()->notNull()
        );

        // 5. Recriar índice
        $this->createIndex(
            'idx-destinos_favoritos-boleia_id',
            'destinos_favoritos',
            'boleia_id'
        );

        // 6. Recriar FK
        $this->addForeignKey(
            'fk-destinos_favoritos-boleia_id',
            'destinos_favoritos',
            'boleia_id',
            'boleias',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Reverter NOT NULL
        $this->dropForeignKey('fk-destinos_favoritos-boleia_id', 'destinos_favoritos');
        $this->dropIndex('idx-destinos_favoritos-boleia_id', 'destinos_favoritos');

        $this->alterColumn('destinos_favoritos', 'boleia_id', $this->integer());

        $this->createIndex('idx-destinos_favoritos-boleia_id', 'destinos_favoritos', 'boleia_id');
        $this->addForeignKey(
            'fk-destinos_favoritos-boleia_id',
            'destinos_favoritos',
            'boleia_id',
            'boleias',
            'id'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251202_204832_fix_boleia_id_obrigatorio cannot be reverted.\n";

        return false;
    }
    */
}
