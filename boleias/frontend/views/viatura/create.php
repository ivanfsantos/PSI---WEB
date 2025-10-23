<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Viatura $model */

$this->title = 'Create Viatura';
$this->params['breadcrumbs'][] = ['label' => 'Viaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="viatura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
