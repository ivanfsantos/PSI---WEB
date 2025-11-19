<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Boleia $model */

$this->title = 'Update Boleia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Boleias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="boleia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'viaturas' => $viaturas,

    ]) ?>

</div>
