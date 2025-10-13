<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacoes".
 *
 * @property int $id
 * @property string $descricao
 * @property int $rating
 * @property int $boleia_id
 * @property int $perfil_id
 *
 * @property Boleias $boleia
 * @property Perfis $perfil
 */
class Avaliacao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'rating', 'boleia_id', 'perfil_id'], 'required'],
            [['descricao'], 'string'],
            [['rating', 'boleia_id', 'perfil_id'], 'integer'],
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
            'descricao' => 'Descricao',
            'rating' => 'Rating',
            'boleia_id' => 'Boleia ID',
            'perfil_id' => 'Perfil ID',
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
