<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class DestinoFavoritoController extends ApiController
{
    public $modelClass = 'common\models\DestinoFavorito';

    public function actionCount()
    {
        $favoritosmodel = new $this->modelClass;
        $recs = $favoritosmodel::find()->all();
        return ['count' => count($recs)];
    }
}