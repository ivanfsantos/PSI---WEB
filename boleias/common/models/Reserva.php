<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property string $estado
 * @property int $perfil_id
 * @property int $boleia_id
 *
 * @property Boleias $boleia
 * @property Perfis $perfil
 */
class Reserva extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado', 'perfil_id', 'boleia_id'], 'required'],
            [['perfil_id', 'boleia_id'], 'integer'],
            [['estado'], 'string', 'max' => 20],
            [['boleia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Boleia::class, 'targetAttribute' => ['boleia_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado' => 'Estado',
            'perfil_id' => 'Perfil ID',
            'boleia_id' => 'Boleia ID',
        ];
    }

    /**
     * Gets query for [[Boleia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoleia()
    {
        return $this->hasOne(Boleia::class, ['id' => 'boleia_id']);
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
