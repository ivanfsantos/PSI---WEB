<?php

/** @var yii\web\View $this */

use yii\grid\GridView;

$this->title = 'My Yii Application';

?>
<div class="site-index">
    <div class="d-flex justify-content-center">
        <h1>Bem-vindo <?= Yii::$app->user->identity->username ?></h1>
    </div>


</div>
