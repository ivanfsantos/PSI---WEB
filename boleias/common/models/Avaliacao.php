<?php

namespace common\models;

use Yii;

class Avaliacao extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'avaliacoes';
    }


    public function rules()
    {
        return [
            [['descricao','perfil_id'], 'required'],
            [['descricao'], 'string'],
            [['perfil_id'], 'integer'],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
            'perfil_id' => 'Perfil ID',
        ];
    }


    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
