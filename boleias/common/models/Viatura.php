<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "viaturas".
 *
 * @property int $id
 * @property string $marca
 * @property string $modelo
 * @property string $matricula
 * @property string $cor
 * @property int $lugares_disponiveis
 * @property int $perfil_id
 *
 * @property Boleias[] $boleias
 * @property Perfis $perfil
 */
class Viatura extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viaturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marca', 'modelo', 'matricula', 'cor', 'perfil_id'], 'required'],
            [['perfil_id'], 'integer'],
            [['marca', 'modelo'], 'string', 'max' => 50],
            [['matricula'], 'string', 'max' => 15],
            [['cor'], 'string', 'max' => 20],
            [['matricula'], 'unique'],
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
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'matricula' => 'Matricula',
            'cor' => 'Cor',
            'perfil_id' => 'Perfil ID',
        ];
    }

    /**
     * Gets query for [[Boleias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBoleias()
    {
        return $this->hasMany(Boleia::class, ['viatura_id' => 'id']);
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
