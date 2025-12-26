<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;


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


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->descricao = $this->descricao;

        $json = json_encode($obj);

        $this->FazPublishNoMosquitto("AVALIACAO_FEITA", $json);
    }


     public function FazPublishNoMosquitto($canal, $msg)
    {
        file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CHAMADO\n", FILE_APPEND);

            $mqtt = new phpMQTT("172.22.21.244", 1883, "avaliacao-" . uniqid());

        if ($mqtt->connect(true, NULL, "", "")) {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CONECTADO\n", FILE_APPEND);
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "FALHOU\n", FILE_APPEND);
        }
    }

}
