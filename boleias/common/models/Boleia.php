<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;

class Boleia extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'boleias';
    }

    public function rules()
    {
        return [
            [['origem', 'destino', 'data_hora', 'lugares_disponiveis', 'viatura_id'], 'required'],
            [['data_hora'], 'safe'],
            [['viatura_id','lugares_disponiveis'], 'integer'],
            [['origem', 'destino'], 'string', 'max' => 255],
            [['preco'], 'number'],
            [['viatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Viatura::class, 'targetAttribute' => ['viatura_id' => 'id']],
            ['viatura_id', 'validateCondutor'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'origem' => 'Origem',
            'destino' => 'Destino',
            'data_hora' => 'Data Hora',
            'lugares_disponiveis' => 'Lugares Disponiveis',
            'viatura_id' => 'Viatura ID',
        ];
    }


    public function validateCondutor($attribute, $params)
    {
        $viatura = Viatura::findOne($this->$attribute);
        if (!$viatura || !$viatura->perfil || !$viatura->perfil->condutor) {
            $this->addError($attribute, 'A boleia só pode ser criada por um condutor.');
        }
    }

    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['boleia_id' => 'id']);
    }

    public function getDestinosFavoritos()
    {
        return $this->hasMany(DestinoFavorito::class, ['boleia_id' => 'id']);
    }

    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['boleia_id' => 'id']);
    }

    public function getViatura()
    {
        return $this->hasOne(Viatura::class, ['id' => 'viatura_id']);
    }

    public function isFechada()
    {
        return $this->getReservas()->andWhere(['estado' => 'pago'])->exists();
    }
    

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->origem = $this->origem;
        $obj->destino = $this->destino;
        $obj->data_hora = $this->data_hora;
        $obj->lugares_disponiveis = $this->lugares_disponiveis;
        $obj->preco = $this->preco;
        $obj->viatura_id = $this->viatura_id;

        $json = json_encode($obj);

        if ($insert)
            $this->FazPublishNoMosquitto("BOLEIA_INSERT", $json);
        else
            $this->FazPublishNoMosquitto("BOLEIA_UPDATE", $json);
    }


    public function afterDelete()
    {
        parent::afterDelete();

        $obj = new \stdClass();
        $obj->id = $this->id;

        $json = json_encode($obj);
        $this->FazPublishNoMosquitto("BOLEIA_DELETE", $json);
    }

    

    public function FazPublishNoMosquitto($canal, $msg)
    {
        file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CHAMADO\n", FILE_APPEND);

            $mqtt = new phpMQTT("127.0.0.1", 1883, "boleia-" . uniqid());

        if ($mqtt->connect(true, NULL, "", "")) {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "CONECTADO\n", FILE_APPEND);
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("C:/wamp64/www/mqtt_debug.txt", "FALHOU\n", FILE_APPEND);
        }
        
    } 
 
}
