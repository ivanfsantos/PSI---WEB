<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Viatura;

class ViaturaSearch extends Viatura
{
    public function rules()
    {
        return [
            [['id', 'perfil_id'], 'integer'],
            [['marca', 'modelo', 'matricula', 'cor'], 'safe'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $formName = null)
    {
        $query = Viatura::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'perfil_id' => $this->perfil_id,
        ]);

        $query->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'cor', $this->cor]);

        return $dataProvider;
    }
}
