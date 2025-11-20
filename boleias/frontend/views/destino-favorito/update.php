<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DestinoFavorito $model */

$this->title = 'Update Destino Favorito: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Destino Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destino-favorito-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
