<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class AvaliacaoController extends ActiveController
{
    public $modelClass = 'common\models\Avaliacao';

    public function actionCount()
    {
        $avaliacoesmodel = new $this->modelClass;
        $recs = $avaliacoesmodel::find()->all();
        return ['count' => count($recs)];
    }
}