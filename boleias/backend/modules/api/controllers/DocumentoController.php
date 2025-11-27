<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class DocumentoController extends ActiveController
{
    public $modelClass = 'common\models\Documento';

    public function actionCount()
    {
        $documentosmodel = new $this->modelClass;
        $recs = $documentosmodel::find()->all();
        return ['count' => count($recs)];
    }
}