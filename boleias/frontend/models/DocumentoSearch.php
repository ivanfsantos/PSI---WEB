<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Documento;

/**
 * DocumentoSearch represents the model behind the search form of `common\models\Documento`.
 */
class DocumentoSearch extends Documento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'valido', 'perfil_id'], 'integer'],
            [['carta_conducao', 'cartao_cidadao'], 'safe'],
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
        $query = Documento::find();

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
            'valido' => $this->valido,
            'perfil_id' => $this->perfil_id,
        ]);

        $query->andFilterWhere(['like', 'carta_conducao', $this->carta_conducao])
            ->andFilterWhere(['like', 'cartao_cidadao', $this->cartao_cidadao]);

        return $dataProvider;
    }
}
