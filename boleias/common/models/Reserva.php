<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;

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


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        $obj = new \stdClass();
        $obj->id = $this->id;       
        $obj->estado = $this->estado;
        $obj->reembolso = $this->reembolso;

        $json = json_encode($obj);

        $this->FazPublishNoMosquitto("RESERVA_VALIDADA", $json);
    }
    

    public function FazPublishNoMosquitto($canal, $msg)
    {
        file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CHAMADO\n", FILE_APPEND);

            $mqtt = new phpMQTT("127.0.0.1", 1883, "reserva-" . uniqid());

        if ($mqtt->connect(true, NULL, "", "")) {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CONECTADO\n", FILE_APPEND);
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "FALHOU\n", FILE_APPEND);
        }
    }

}
