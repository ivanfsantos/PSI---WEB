<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Avaliacao;


class AvaliacaoSearch extends Avaliacao
{

    public function rules()
    {
        return [
            [['id', 'perfil_id'], 'integer'],
            [['descricao'], 'safe'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params, $formName = null)
    {
        $query = Avaliacao::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'perfil_id' => $this->perfil_id,
        ]);

        $query->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
