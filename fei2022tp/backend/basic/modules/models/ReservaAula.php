<?php

namespace app\modules\models;

use Yii;

/**
 * This is the model class for table "reserva_aula".
 *
 * @property int $id
 * @property string|null $fh_desde
 * @property string|null $fh_hasta
 * @property string|null $observacion
 * @property int|null $id_aula
 *
 * @property Aula $aula
 * @property HorarioMateria[] $horarioMaterias
 */
class ReservaAula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_aula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fh_desde', 'fh_hasta'], 'safe'],
            [['id_aula'], 'default', 'value' => null],
            [['id_aula'], 'integer'],
            [['observacion'], 'string', 'max' => 256],
            [['id_aula'], 'exist', 'skipOnError' => true, 'targetClass' => Aula::className(), 'targetAttribute' => ['id_aula' => 'id']],
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
            'id_aula' => 'Id Aula',
        ];
    }

    /**
     * Gets query for [[Aula]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAula()
    {
        return $this->hasOne(Aula::className(), ['id' => 'id_aula']);
    }

    /**
     * Gets query for [[HorarioMaterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorarioMaterias()
    {
        return $this->hasMany(HorarioMateria::className(), ['id_reserva' => 'id']);
    }
}
