<?php

namespace app\modules\models;

use Yii;

/**
 * This is the model class for table "aula".
 *
 * @property int $id
 * @property string $descripccion
 * @property string $ubicacion
 * @property int|null $cant_proyector
 * @property int|null $cant_pcs
 * @property int|null $aforo
 * @property bool|null $es_climatizado
 *
 * @property ReservaAula[] $reservaAulas
 */
class Aula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripccion', 'ubicacion'], 'required'],
            [['cant_proyector', 'cant_pcs', 'aforo'], 'default', 'value' => null],
            [['cant_proyector', 'cant_pcs', 'aforo'], 'integer'],
            [['es_climatizado'], 'boolean'],
            [['descripccion', 'ubicacion'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripccion' => 'Descripccion',
            'ubicacion' => 'Ubicacion',
            'cant_proyector' => 'Cant Proyector',
            'cant_pcs' => 'Cant Pcs',
            'aforo' => 'Aforo',
            'es_climatizado' => 'Es Climatizado',
        ];
    }

    /**
     * Gets query for [[ReservaAulas]].
     *
     * @return \yii\db\ActiveQuery|ReservaAulaQuery
     */
    public function getReservaAulas()
    {
        return $this->hasMany(ReservaAula::className(), ['id_aula' => 'id']);
    }
}
