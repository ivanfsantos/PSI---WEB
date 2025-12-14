<?php

namespace common\models;

use Yii;


class Viatura extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'viaturas';
    }

    public function rules()
    {
        return [
            [['marca', 'modelo', 'matricula', 'cor', 'perfil_id'], 'required'],
            [['perfil_id'], 'integer'],
            [['marca', 'modelo'], 'string', 'max' => 50],
            [['matricula'], 'string', 'max' => 15],
            [['cor'], 'string', 'max' => 20],
            [['matricula'], 'unique'],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'matricula' => 'Matricula',
            'cor' => 'Cor',
            'perfil_id' => 'Perfil ID',
        ];
    }

    public function getBoleias()
    {
        return $this->hasMany(Boleia::class, ['viatura_id' => 'id']);
    }

    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
