<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class MensagemController extends ActiveController
{
    public $modelClass = 'common\models\Mensagem';

    public function actionCount()
    {
        $viaturasmodel = new $this->modelClass;
        $recs = $viaturasmodel::find()->all();
        return ['count' => count($recs)];
    }

    public function actionMensagens()
    {
        $mensagensmodel = new $this->modelClass;
        $recs = $mensagensmodel::find()->select(['mensagem'])->all();
        return $recs;
    }
}