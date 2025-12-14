<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reserva;


class ReservaSearch extends Reserva
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
        $query = Reserva::find();

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
