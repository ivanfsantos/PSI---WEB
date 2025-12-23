<?php

namespace common\models;

use Yii;


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
    


}
