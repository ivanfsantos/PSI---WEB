<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "boleias".
 *
 * @property int $id
 * @property string $origem
 * @property string $destino
 * @property string $data_hora
 * @property int $viatura_id
 *
 * @property Avaliacoes[] $avaliacoes
 * @property DestinosFavoritos[] $destinosFavoritos
 * @property Reservas[] $reservas
 * @property Viaturas $viatura
 */
class Boleia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'boleias';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Gets query for [[Avaliacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['boleia_id' => 'id']);
    }

    /**
     * Gets query for [[DestinosFavoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinosFavoritos()
    {
        return $this->hasMany(DestinoFavorito::class, ['boleia_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['boleia_id' => 'id']);
    }

    /**
     * Gets query for [[Viatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViatura()
    {
        return $this->hasOne(Viatura::class, ['id' => 'viatura_id']);


    }

    public function isFechada()
    {
        return $this->getReservas()->andWhere(['estado' => 'pago'])->exists();
    }

}
