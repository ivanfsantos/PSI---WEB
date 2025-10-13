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
            [['boleia_id'], 'default', 'value' => null],
            [['boleia_id'], 'integer'],
            [['boleia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Boleia::class, 'targetAttribute' => ['boleia_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'boleia_id' => 'Boleia ID',
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

}
