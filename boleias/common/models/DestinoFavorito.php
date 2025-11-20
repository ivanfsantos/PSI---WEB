<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "destinos_favoritos".
 *
 * @property int $id
 * @property int|null $boleia_id
 *
 * @property Boleias $boleia
 */
class DestinoFavorito extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destinos_favoritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perfil_id', 'tipo', 'endereco'], 'required'],
            [['perfil_id'], 'integer'],
            [['tipo'], 'in', 'range' => ['origem', 'destino']],
            [['endereco'], 'string', 'max' => 255],
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
            'tipo' => 'Tipo',
            'endereco' => 'Endereço',
        ];
    }

    /**
     * Gets query for [[Boleia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

}
