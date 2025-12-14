<?php

namespace common\models;

use app\models\PersonForm;
use Yii;


class Documento extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'documentos';
    }


    public function rules()
    {
        return [
            [['carta_conducao', 'cartao_cidadao', 'perfil_id'], 'default', 'value' => null],
            [['valido'], 'required'],
            [['valido', 'perfil_id'], 'integer'],
            [['carta_conducao', 'cartao_cidadao'], 'string', 'max' => 255],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'carta_conducao' => 'Carta Conducao',
            'cartao_cidadao' => 'Cartao Cidadao',
            'valido' => 'Valido',
            'perfil_id' => 'Perfil ID',
        ];
    }


    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
