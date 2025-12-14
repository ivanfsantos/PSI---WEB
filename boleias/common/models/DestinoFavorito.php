<?php

namespace common\models;

use Yii;


class DestinoFavorito extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'destinos_favoritos';
    }


    public function attributes()
    {
        return array_merge(parent::attributes(), ['perfil_id', 'boleia_id']);
    }


    public function rules()
    {
        return [
            [['perfil_id', 'boleia_id'], 'required'],
            [['perfil_id', 'boleia_id'], 'integer'],

            [
                ['perfil_id'],
                'exist',
                'skipOnEmpty' => false,
                'targetClass' => Perfil::class,
                'targetAttribute' => ['perfil_id' => 'id']
            ],

            [
                ['boleia_id'],
                'exist',
                'skipOnEmpty' => false,
                'targetClass' => Boleia::class,
                'targetAttribute' => ['boleia_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perfil_id' => 'Perfil',
            'boleia_id' => 'Boleia',
        ];
    }

    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

    public function getBoleia()
    {
        return $this->hasOne(Boleia::class, ['id' => 'boleia_id']);
    }
}
