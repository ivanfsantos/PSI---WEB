<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Boleia $model */

$this->title = 'Create Boleia';
$this->params['breadcrumbs'][] = ['label' => 'Boleias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boleia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'viaturas' => $viaturas,
    ]) ?>

</div>
