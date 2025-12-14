<?php

namespace common\models;

use Yii;


class CondutorFavorito extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'condutores_favoritos';
    }

    public function rules()
    {
        return [
            [['perfil_id_user', 'perfil_id_condutor'], 'required'],
            [['perfil_id_user', 'perfil_id_condutor'], 'integer'],
            [['perfil_id_user', 'perfil_id_condutor'], 'unique', 'targetAttribute' => ['perfil_id_user', 'perfil_id_condutor'], 'message' => 'Você já adicionou este condutor aos favoritos.'],
            [['perfil_id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id_user' => 'id']],
            [['perfil_id_condutor'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id_condutor' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perfil_id_user' => 'Usuário',
            'perfil_id_condutor' => 'Condutor Favorito',
        ];
    }


    public function getUserPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id_user']);
    }


    public function getCondutorPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id_condutor']);
    }
}
