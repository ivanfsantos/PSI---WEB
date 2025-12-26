<?php

namespace common\models;

use app\models\PersonForm;
use Yii;
use common\mosquitto\phpMQTT;



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


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->valido = $this->valido;

        $json = json_encode($obj);

        $this->FazPublishNoMosquitto("DOCUMENTOS_VALIDADOS", $json);
    }


    public function FazPublishNoMosquitto($canal, $msg)
    {
        file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CHAMADO\n", FILE_APPEND);

            $mqtt = new phpMQTT("172.22.21.244", 1883, "documento-" . uniqid());

        if ($mqtt->connect(true, NULL, "", "")) {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CONECTADO\n", FILE_APPEND);
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "FALHOU\n", FILE_APPEND);
        }
    }

}
