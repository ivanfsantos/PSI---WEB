<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Boleia;

/**
 * BoleiaSearch represents the model behind the search form of `common\models\Boleia`.
 */
class BoleiaSearch extends Boleia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'viatura_id'], 'integer'],
            [['origem', 'destino', 'data_hora'], 'safe'],
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
        $query = Boleia::find();

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
            'data_hora' => $this->data_hora,
            'viatura_id' => $this->viatura_id,
        ]);

        $query->andFilterWhere(['like', 'origem', $this->origem])
            ->andFilterWhere(['like', 'destino', $this->destino]);

        return $dataProvider;
    }
}
