<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class ReservaController extends ApiController
{
    public $modelClass = 'common\models\Reserva';

    public function actionCount()
    {
        $reservasmodel = new $this->modelClass;
        $recs = $reservasmodel::find()->all();
        return ['count' => count($recs)];
    }
}
