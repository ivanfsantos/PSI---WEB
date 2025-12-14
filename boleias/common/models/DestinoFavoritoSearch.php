<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DestinoFavorito;


class DestinoFavoritoSearch extends DestinoFavorito
{

    public function rules()
    {
        return [
            [['id', 'perfil_id', 'boleia_id'], 'integer'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params, $formName = null)
    {
        $query = DestinoFavorito::find()->joinWith('boleia');

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
            'boleia_id' => $this->boleia_id,
        ]);

        return $dataProvider;
    }
}
