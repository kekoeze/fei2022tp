<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%aula}}`.
 */
class m220714_165557_create_aula_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aula}}', [
            'id' => $this->primaryKey(),
            'descripccion' => $this->string(128)->notNull(),
            'ubicacion' => $this->string(128)->notNull(),
            'cant_proyector' => $this->integer()->defaultValue(0),
            'aforo' => $this->integer()->defaultValue(0),
            'es_climatizado' => $this->boolean()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%aula}}');
    }
}
