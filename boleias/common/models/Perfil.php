<?php

namespace common\models;

use Yii;

class Perfil extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'perfis';
    }

    public function rules()
    {
        return [
            [['nome', 'telefone', 'morada', 'genero', 'data_nascimento', 'condutor', 'user_id'], 'required'],
            [['telefone', 'condutor', 'user_id'], 'integer'],
            [['data_nascimento'], 'safe'],
            [['nome', 'genero'], 'string', 'max' => 30],
            [['morada'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'morada' => 'Morada',
            'genero' => 'Genero',
            'data_nascimento' => 'Data Nascimento',
            'condutor' => 'Condutor',
            'user_id' => 'User ID',
        ];
    }


    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['perfil_id' => 'id']);
    }


    public function getDocumentos()
    {
        return $this->hasMany(Documento::class, ['perfil_id' => 'id']);
    }



    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['perfil_id' => 'id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public function getViaturas()
    {
        return $this->hasMany(Viatura::class, ['perfil_id' => 'id']);
    }



}
