<?php

namespace app\modules\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string|null $usuario
 * @property string|null $contrasenia
 * @property string|null $email
 * @property bool|null $isAdmin
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isAdmin'], 'boolean'],
            [['usuario', 'email'], 'string', 'max' => 40],
            [['contrasenia'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'contrasenia' => 'Contrasenia',
            'email' => 'Email',
            'isAdmin' => 'Is Admin',
        ];
    }
}
