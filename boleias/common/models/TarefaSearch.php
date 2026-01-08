<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tarefa;

/**
 * TarefaSearch represents the model behind the search form of `common\models\Tarefa`.
 */
class TarefaSearch extends Tarefa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'criador', 'atribuido'], 'integer'],
            [['titulo', 'descricao', 'estado', 'data_criacao', 'data_atualizacao', 'data_confirmacao'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Tarefa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'criador' => $this->criador,
            'atribuido' => $this->atribuido,
            'data_criacao' => $this->data_criacao,
            'data_atualizacao' => $this->data_atualizacao,
            'data_confirmacao' => $this->data_confirmacao,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
