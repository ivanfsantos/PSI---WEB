<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "condutor_favorito".
 *
 * @property int $id
 * @property int $passageiro_id
 * @property int $condutor_id
 *
 * @property Perfil $condutor
 * @property Perfil $passageiro
 */
class CondutorFavorito extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condutor_favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['passageiro_id', 'condutor_id'], 'required'],
            [['passageiro_id', 'condutor_id'], 'integer'],
            [['passageiro_id', 'condutor_id'], 'unique', 'targetAttribute' => ['passageiro_id', 'condutor_id']],
            [['condutor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['condutor_id' => 'id']],
            [['passageiro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['passageiro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'passageiro_id' => 'Passageiro ID',
            'condutor_id' => 'Condutor ID',
        ];
    }

    /**
     * Gets query for [[Condutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCondutor()
    {
        return $this->hasOne(Perfil::class, ['id' => 'condutor_id']);
    }

    /**
     * Gets query for [[Passageiro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPassageiro()
    {
        return $this->hasOne(Perfil::class, ['id' => 'passageiro_id']);
    }

}
