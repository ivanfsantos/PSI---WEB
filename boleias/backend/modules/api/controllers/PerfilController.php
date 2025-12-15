<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class PerfilController extends ApiController
{
    public $modelClass = 'common\models\Perfil';

    public function actionCount()
    {
        $viaturasmodel = new $this->modelClass;
        $recs = $viaturasmodel::find()->all();
        return ['count' => count($recs)];
    }

    public function actionNomes()
    {
        $nomesmodel = new $this->modelClass;
        $recs = $nomesmodel::find()->select(['nome'])->all();
        return $recs;
    }

    public function actionTelefones()
    {
        $telefonesmodel = new $this->modelClass;
        $recs = $telefonesmodel::find()->select(['telefone'])->all();
        return $recs;
    }

    public function actionMoradas()
    {
        $moradasmodel = new $this->modelClass;
        $recs = $moradasmodel::find()->select(['morada'])->all();
        return $recs;
    }

    public function actionGeneros()
    {
        $generosmodel = new $this->modelClass;
        $recs = $generosmodel::find()->select(['genero'])->all();
        return $recs;
    }

    public function actionDatasnascimentos()
    {
        $datasnascimentomodel = new $this->modelClass;
        $recs = $datasnascimentomodel::find()->select(['data_nascimento'])->all();
        return $recs;
    }
}