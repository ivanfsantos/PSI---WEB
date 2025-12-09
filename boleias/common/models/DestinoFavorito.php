<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "destinos_favoritos".
 *
 * @property int $id
 * @property int $perfil_id
 * @property int $boleia_id
 *
 * @property Perfil $perfil
 * @property Boleia $boleia
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
     * Garante que o ActiveRecord reconhece todas as colunas,
     * mesmo que tenham sido adicionadas depois por migrações.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['perfil_id', 'boleia_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Ambos obrigatórios
            [['perfil_id', 'boleia_id'], 'required'],

            // Têm de ser inteiros
            [['perfil_id', 'boleia_id'], 'integer'],

            // FK perfil
            [
                ['perfil_id'],
                'exist',
                'skipOnEmpty' => false,
                'targetClass' => Perfil::class,
                'targetAttribute' => ['perfil_id' => 'id']
            ],

            // FK boleia
            [
                ['boleia_id'],
                'exist',
                'skipOnEmpty' => false,
                'targetClass' => Boleia::class,
                'targetAttribute' => ['boleia_id' => 'id']
            ],
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
        ];
    }

    /**
     * Relação com Perfil
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }

    /**
     * Relação com Boleia
     */
    public function getBoleia()
    {
        return $this->hasOne(Boleia::class, ['id' => 'boleia_id']);
    }
}
