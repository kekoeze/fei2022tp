<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%carrera}}`.
 */
class m220713_222231_create_carrera_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%carrera}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(12)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%carrera}}');
    }
}
