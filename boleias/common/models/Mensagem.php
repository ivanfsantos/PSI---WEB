<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mensagens".
 *
 * @property int $id
 * @property string|null $mensagem
 * @property int|null $remetente_id
 * @property int|null $destinatario_id
 *
 * @property Perfis $destinatario
 * @property Perfis $remetente
 */
class Mensagem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mensagem', 'remetente_id', 'destinatario_id'], 'default', 'value' => null],
            [['mensagem'], 'string'],
            [['remetente_id', 'destinatario_id'], 'integer'],
            [['destinatario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['destinatario_id' => 'id']],
            [['remetente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['remetente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mensagem' => 'Mensagem',
            'remetente_id' => 'Remetente ID',
            'destinatario_id' => 'Destinatario ID',
        ];
    }

    /**
     * Gets query for [[Destinatario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinatario()
    {
        return $this->hasOne(Perfil::class, ['id' => 'destinatario_id']);
    }

    /**
     * Gets query for [[Remetente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRemetente()
    {
        return $this->hasOne(Perfil::class, ['id' => 'remetente_id']);
    }

}
