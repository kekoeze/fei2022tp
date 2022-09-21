<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reserva_aula}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%id_materia}}`
 * - `{{%id_aula}}`
 */
class m220824_191008_create_reserva_aula_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reserva_aula}}', [
            'id' => $this->primaryKey(),
            'fh_desde' => $this->dateTime(),
            'fh_hasta' => $this->dateTime(),
            'observacion' => $this->string(256),
            'id_materia' => $this->integer(),
            'id_aula' => $this->integer(),
        ]);

        // creates index for column `id_materia`
        $this->createIndex(
            '{{%idx-reserva_aula-id_materia}}',
            '{{%reserva_aula}}',
            'id_materia'
        );

        // add foreign key for table `{{%id_materia}}`
        $this->addForeignKey(
            '{{%fk-reserva_aula-id_materia}}',
            '{{%reserva_aula}}',
            'id_materia',
            '{{%materia}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_aula`
        $this->createIndex(
            '{{%idx-reserva_aula-id_aula}}',
            '{{%reserva_aula}}',
            'id_aula'
        );

        // add foreign key for table `{{%id_aula}}`
        $this->addForeignKey(
            '{{%fk-reserva_aula-id_aula}}',
            '{{%reserva_aula}}',
            'id_aula',
            '{{%aula}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%id_materia}}`
        $this->dropForeignKey(
            '{{%fk-reserva_aula-id_materia}}',
            '{{%reserva_aula}}'
        );

        // drops index for column `id_materia`
        $this->dropIndex(
            '{{%idx-reserva_aula-id_materia}}',
            '{{%reserva_aula}}'
        );

        // drops foreign key for table `{{%id_aula}}`
        $this->dropForeignKey(
            '{{%fk-reserva_aula-id_aula}}',
            '{{%reserva_aula}}'
        );

        // drops index for column `id_aula`
        $this->dropIndex(
            '{{%idx-reserva_aula-id_aula}}',
            '{{%reserva_aula}}'
        );

        $this->dropTable('{{%reserva_aula}}');
    }
}
