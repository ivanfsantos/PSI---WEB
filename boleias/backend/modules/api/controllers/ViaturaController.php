<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class ViaturaController extends ApiController
{
    public $modelClass = 'common\models\Viatura';

    public function actionCount()
    {
        $viaturasmodel = new $this->modelClass;
        $recs = $viaturasmodel::find()->all();
        return ['count' => count($recs)];
    }

    public function actionMarcas()
    {
        $marcasmodel = new $this->modelClass;
        $recs = $marcasmodel::find()->select(['marca'])->all();
        return $recs;
    }

    public function actionModelos()
    {
        $modelosmodel = new $this->modelClass;
        $recs = $modelosmodel::find()->select(['modelo'])->all();
        return $recs;
    }

    public function actionMatriculas()
    {
        $matriculasmodel = new $this->modelClass;
        $recs = $matriculasmodel::find()->select(['matricula'])->all();
        return $recs;
    }

    public function actionCores()
    {
        $coresmodel = new $this->modelClass;
        $recs = $coresmodel::find()->select(['cor'])->all();
        return $recs;
    }

    public function actionLugaresdisponiveis()
    {
        $lugaresdisponiveismodel = new $this->modelClass;
        $recs = $lugaresdisponiveismodel::find()->select(['lugares_disponiveis'])->all();
        return $recs;
    }
}
