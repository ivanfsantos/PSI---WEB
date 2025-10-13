<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "perfis".
 *
 * @property int $id
 * @property string $nome
 * @property int $telefone
 * @property string $morada
 * @property string $genero
 * @property string $data_nascimento
 * @property int $condutor
 * @property int $user_id
 *
 * @property Avaliacoes[] $avaliacoes
 * @property Documentos[] $documentos
 * @property Mensagens[] $mensagens
 * @property Mensagens[] $mensagens0
 * @property Reservas[] $reservas
 * @property User $user
 * @property Viaturas[] $viaturas
 */
class Perfil extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'telefone', 'morada', 'genero', 'data_nascimento', 'condutor', 'user_id'], 'required'],
            [['telefone', 'condutor', 'user_id'], 'integer'],
            [['data_nascimento'], 'safe'],
            [['nome', 'genero'], 'string', 'max' => 30],
            [['morada'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'morada' => 'Morada',
            'genero' => 'Genero',
            'data_nascimento' => 'Data Nascimento',
            'condutor' => 'Condutor',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Avaliacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['perfil_id' => 'id']);
    }

    /**
     * Gets query for [[Documentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documento::class, ['perfil_id' => 'id']);
    }

    /**
     * Gets query for [[Mensagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagens()
    {
        return $this->hasMany(Mensagem::class, ['destinatario_id' => 'id']);
    }

    /**
     * Gets query for [[Mensagens0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagens0()
    {
        return $this->hasMany(Mensagem::class, ['remetente_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['perfil_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Viaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViaturas()
    {
        return $this->hasMany(Viatura::class, ['perfil_id' => 'id']);
    }

}
