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
 * @property int|null $id_materia
 * @property int|null $id_aula
 *
 * @property Aula $aula
 * @property Materia $materia
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
            [['id_materia', 'id_aula'], 'default', 'value' => null],
            [['id_materia', 'id_aula'], 'integer'],
            [['observacion'], 'string', 'max' => 256],
            [['id_aula'], 'exist', 'skipOnError' => true, 'targetClass' => Aula::className(), 'targetAttribute' => ['id_aula' => 'id']],
            [['id_materia'], 'exist', 'skipOnError' => true, 'targetClass' => Materia::className(), 'targetAttribute' => ['id_materia' => 'id']],
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
     * Gets query for [[Materia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMateria()
    {
        return $this->hasOne(Materia::className(), ['id' => 'id_materia']);
    }
}
