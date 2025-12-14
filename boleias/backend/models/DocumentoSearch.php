<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Documento;


class DocumentoSearch extends Documento
{

    public function rules()
    {
        return [
            [['id', 'valido', 'perfil_id'], 'integer'],
            [['carta_conducao', 'cartao_cidadao'], 'safe'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params, $formName = null)
    {
        $query = Documento::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

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
