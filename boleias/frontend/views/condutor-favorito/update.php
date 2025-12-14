<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CondutorFavorito $model */

$this->title = 'Update Condutor Favorito: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Condutor Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="condutor-favorito-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
