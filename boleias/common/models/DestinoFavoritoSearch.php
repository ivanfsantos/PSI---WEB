<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DestinoFavorito;

/**
 * DestinoFavoritoSearch represents the model behind the search form of `common\models\DestinoFavorito`.
 */
class DestinoFavoritoSearch extends DestinoFavorito
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perfil_id', 'boleia_id'], 'integer'], // ✔ campos reais da BD
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Search query
     */
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

        // ✔ filtros corretos
        $query->andFilterWhere([
            'id' => $this->id,
            'perfil_id' => $this->perfil_id,
            'boleia_id' => $this->boleia_id,
        ]);

        return $dataProvider;
    }
}
