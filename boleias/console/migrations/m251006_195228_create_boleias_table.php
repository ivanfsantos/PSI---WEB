<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%boleias}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%reservas}}`
 */
class m251006_195228_create_boleias_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%boleias}}', [
            'id' => $this->primaryKey(),
            'origem' => $this->string(255)->notNull(),
            'destino' => $this->string(255)->notNull(),
            'data_hora' => $this->datetime()->notNull(),
            'lugares_disponiveis' => $this->integer()->notNull(),
            'preco' => $this->decimal(10,2)->notNull(),
            'viatura_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        // creates index for column `viatura_id`
        $this->createIndex(
            '{{%idx-boleias-viatura_id}}',
            '{{%boleias}}',
            'viatura_id'
        );

        // add foreign key for table `{{%viaturas}}`
        $this->addForeignKey(
            '{{%fk-boleias-viatura_id}}',
            '{{%boleias}}',
            'viatura_id',
            '{{%viaturas}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%viaturas}}`
        $this->dropForeignKey(
            '{{%fk-boleias-viatura_id}}',
            '{{%boleias}}'
        );

        // drops index for column `viatura_id`
        $this->dropIndex(
            '{{%idx-boleias-viatura_id}}',
            '{{%boleias}}'
        );

        $this->dropTable('{{%boleias}}');
    }
}
