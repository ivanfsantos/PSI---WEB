<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class BoleiaController extends ActiveController
{
    public $modelClass = 'common\models\Boleia';

    public function actionCount()
    {
        $boleiasmodel = new $this->modelClass;
        $recs = $boleiasmodel::find()->all();
        return ['count' => count($recs)];
    }
}