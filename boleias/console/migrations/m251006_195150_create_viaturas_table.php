<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%viaturas}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%perfis}}`
 */
class m251006_195150_create_viaturas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%viaturas}}', [
            'id' => $this->primaryKey(),
            'marca' => $this->string(50)->notNull(),
            'modelo' => $this->string(50)->notNull(),
            'matricula' => $this->string(15)->notNull()->unique(),
            'cor' => $this->string(20)->notNull(),
            'lugares_disponiveis' => $this->integer()->notNull(),
            'perfil_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');

        // creates index for column `perfil_id`
        $this->createIndex(
            '{{%idx-viaturas-perfil_id}}',
            '{{%viaturas}}',
            'perfil_id'
        );

        // add foreign key for table `{{%perfis}}`
        $this->addForeignKey(
            '{{%fk-viaturas-perfil_id}}',
            '{{%viaturas}}',
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
            '{{%fk-viaturas-perfil_id}}',
            '{{%viaturas}}'
        );

        // drops index for column `perfil_id`
        $this->dropIndex(
            '{{%idx-viaturas-perfil_id}}',
            '{{%viaturas}}'
        );

        $this->dropTable('{{%viaturas}}');
    }
}
