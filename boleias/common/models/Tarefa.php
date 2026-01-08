<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tarefas".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $descricao
 * @property int $criador
 * @property int|null $atribuido
 * @property string|null $estado
 * @property string|null $data_criacao
 * @property string|null $data_atualizacao
 * @property string|null $data_confirmacao
 */
class Tarefa extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_ESPERA = 'espera';
    const ESTADO_CONFIRMADO = 'confirmado';
    const ESTADO_FEITO = 'feito';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarefas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'atribuido', 'data_criacao', 'data_atualizacao', 'data_confirmacao'], 'default', 'value' => null],
            [['estado'], 'default', 'value' => 'espera'],
            [['titulo', 'criador'], 'required'],
            [['descricao', 'estado'], 'string'],
            [['criador', 'atribuido'], 'integer'],
            [['data_criacao', 'data_atualizacao', 'data_confirmacao'], 'safe'],
            [['titulo'], 'string', 'max' => 255],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'criador' => 'Criador',
            'atribuido' => 'Atribuido',
            'estado' => 'Estado',
            'data_criacao' => 'Data Criacao',
            'data_atualizacao' => 'Data Atualizacao',
            'data_confirmacao' => 'Data Confirmacao',
        ];
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_ESPERA => 'espera',
            self::ESTADO_CONFIRMADO => 'confirmado',
            self::ESTADO_FEITO => 'feito',
        ];
    }

    /**
     * @return string
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    /**
     * @return bool
     */
    public function isEstadoEspera()
    {
        return $this->estado === self::ESTADO_ESPERA;
    }

    public function setEstadoToEspera()
    {
        $this->estado = self::ESTADO_ESPERA;
    }

    /**
     * @return bool
     */
    public function isEstadoConfirmado()
    {
        return $this->estado === self::ESTADO_CONFIRMADO;
    }

    public function setEstadoToConfirmado()
    {
        $this->estado = self::ESTADO_CONFIRMADO;
    }

    /**
     * @return bool
     */
    public function isEstadoFeito()
    {
        return $this->estado === self::ESTADO_FEITO;
    }

    public function setEstadoToFeito()
    {
        $this->estado = self::ESTADO_FEITO;
    }

    public function getCriadorUser()
    {
        return $this->hasOne(User::class, ['id' => 'criador']);
    }

    public function getAtribuidoUser()
    {
        return $this->hasOne(User::class, ['id' => 'atribuido']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($insert) {
                $this->data_criacao = date('Y-m-d H:i:s');
                $this->criador = Yii::$app->user->id;
            } else {
                $this->data_atualizacao = date('Y-m-d H:i:s');
            }

            return true;
        }
        return false;
    }

}
