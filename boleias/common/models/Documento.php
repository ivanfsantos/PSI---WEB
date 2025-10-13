<?php

namespace common\models;

use app\models\PersonForm;
use Yii;

/**
 * This is the model class for table "documentos".
 *
 * @property int $id
 * @property string|null $carta_conducao
 * @property string|null $cartao_cidadao
 * @property int $valido
 * @property int|null $perfil_id
 *
 * @property Perfil $perfil
 */
class Documento extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['carta_conducao', 'cartao_cidadao', 'perfil_id'], 'default', 'value' => null],
            [['valido'], 'required'],
            [['valido', 'perfil_id'], 'integer'],
            [['carta_conducao', 'cartao_cidadao'], 'string', 'max' => 255],
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
            'carta_conducao' => 'Carta Conducao',
            'cartao_cidadao' => 'Cartao Cidadao',
            'valido' => 'Valido',
            'perfil_id' => 'Perfil ID',
        ];
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
