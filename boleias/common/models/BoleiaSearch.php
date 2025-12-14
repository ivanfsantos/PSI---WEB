<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Boleia;


class BoleiaSearch extends Boleia
{

    public function rules()
    {
        return [
            [['id','lugares_disponiveis','viatura_id'], 'integer'],
            [['origem', 'destino', 'data_hora'], 'safe'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }


        public function search($params, $formName = null)
    {
        $perfil = Perfil::findOne(['user_id' => \Yii::$app->user->id]);

        $query = Boleia::find();

        if ($perfil) {
            $query->joinWith(['destinosFavoritos' => function (\yii\db\ActiveQuery $query) use ($perfil) {
                $query->on('destinos_favoritos.perfil_id = :perfil_id', [':perfil_id' => $perfil->id]);
            }]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'data_hora' => $this->data_hora,
            'lugares_disponiveis' => $this->lugares_disponiveis,
            'viatura_id' => $this->viatura_id,
        ]);

        $query->andFilterWhere(['like', 'origem', $this->origem])
            ->andFilterWhere(['like', 'destino', $this->destino]);

        return $dataProvider;
    }

    }
