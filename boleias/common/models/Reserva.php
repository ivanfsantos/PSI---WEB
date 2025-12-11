<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * * @property string|null $estado
 * * @property int $perfil_id
 * * @property int $boleia_id
 * * @property string|null $ponto_encontro
 * * @property int|null $contacto
 * * @property float|null $reembolso
 * *
 * * @property Boleias $boleia
 * * @property Perfis $perfil
 */
class Reserva extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perfil_id', 'boleia_id', 'contacto'], 'integer'],
            [['reembolso'], 'number'],
            [['ponto_encontro'], 'string'],
            [['boleia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Boleia::class, 'targetAttribute' => ['boleia_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Gets query for [[Boleia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoleia()
    {
        return $this->hasOne(Boleia::class, ['id' => 'boleia_id']);
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
