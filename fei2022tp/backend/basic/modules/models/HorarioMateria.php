<?php

namespace app\modules\models;

use Yii;

/**
 * This is the model class for table "horario_materia".
 *
 * @property int $id
 * @property string|null $fh_desde
 * @property string|null $fh_hasta
 * @property string|null $observacion
 * @property int|null $id_materia
 * @property int|null $id_reserva
 *
 * @property Materia $materia
 * @property ReservaAula $reserva
 */
class HorarioMateria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horario_materia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fh_desde', 'fh_hasta'], 'safe'],
            [['id_materia', 'id_reserva'], 'default', 'value' => null],
            [['id_materia', 'id_reserva'], 'integer'],
            [['observacion'], 'string', 'max' => 256],
            [['id_materia'], 'exist', 'skipOnError' => true, 'targetClass' => Materia::className(), 'targetAttribute' => ['id_materia' => 'id']],
            [['id_reserva'], 'exist', 'skipOnError' => true, 'targetClass' => ReservaAula::className(), 'targetAttribute' => ['id_reserva' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fh_desde' => 'Fh Desde',
            'fh_hasta' => 'Fh Hasta',
            'observacion' => 'Observacion',
            'id_materia' => 'Id Materia',
            'id_reserva' => 'Id Reserva',
        ];
    }

    /**
     * Gets query for [[Materia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMateria()
    {
        return $this->hasOne(Materia::className(), ['id' => 'id_materia']);
    }

    /**
     * Gets query for [[Reserva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReserva()
    {
        return $this->hasOne(ReservaAula::className(), ['id' => 'id_reserva']);
    }
}
