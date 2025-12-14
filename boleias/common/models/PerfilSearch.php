<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Perfil;


class PerfilSearch extends Perfil
{

    public function rules()
    {
        return [
            [['id', 'telefone', 'condutor', 'user_id'], 'integer'],
            [['nome', 'morada', 'genero', 'data_nascimento'], 'safe'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params, $formName = null)
    {
        $query = Perfil::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'telefone' => $this->telefone,
            'data_nascimento' => $this->data_nascimento,
            'condutor' => $this->condutor,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'morada', $this->morada])
            ->andFilterWhere(['like', 'genero', $this->genero]);

        return $dataProvider;
    }
}
