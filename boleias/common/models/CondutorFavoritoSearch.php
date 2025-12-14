<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class CondutorFavoritoSearch extends CondutorFavorito
{

    public function rules()
    {
        return [
            [['id', 'perfil_id_user', 'perfil_id_condutor'], 'integer'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params, $formName = null)
    {
        $query = CondutorFavorito::find();

        $userPerfil = \common\models\Perfil::findOne(['user_id' => \Yii::$app->user->id]);
        if ($userPerfil) {
            $query->andWhere(['perfil_id_user' => $userPerfil->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'perfil_id_user' => $this->perfil_id_user,
            'perfil_id_condutor' => $this->perfil_id_condutor,
        ]);

        return $dataProvider;
    }
}

