<?php

namespace common\models;

use Yii;

class Reserva extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'reservas';
    }

    public function rules()
    {
        return [
            [['perfil_id', 'boleia_id', 'contacto', 'ponto_encontro'], 'required'],
            [['perfil_id', 'boleia_id'], 'integer'],
            [['reembolso'], 'number'],
            [['ponto_encontro', 'contacto'], 'string', 'max' => 255],
            [['boleia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Boleia::class, 'targetAttribute' => ['boleia_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perfil_id' => 'Perfil',
            'boleia_id' => 'Boleia',
            'ponto_encontro' => 'Ponto de Encontro',
            'contacto' => 'Contacto',
            'reembolso' => 'Reembolso',
        ];
    }


    public function getBoleia()
    {
        return $this->hasOne(Boleia::class, ['id' => 'boleia_id']);
    }


    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
