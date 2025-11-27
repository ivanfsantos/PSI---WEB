<?php
namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actionCount()
    {
        $usermodel = new $this->modelClass;
        $recs = $usermodel::find()->all();
        return ['count' => count($recs)];
    }

    public function actionUsernames()
    {
        $usernamesmodel = new $this->modelClass;
        $recs = $usernamesmodel::find()->select(['username'])->all();
        return $recs;
    }

    public function actionEmails()
    {
        $emailsmodel = new $this->modelClass;
        $recs = $emailsmodel::find()->select(['email'])->all();
        return $recs;
    }
}