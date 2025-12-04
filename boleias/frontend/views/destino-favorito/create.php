<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DestinoFavorito $model */

$this->title = 'Create Destino Favorito';
$this->params['breadcrumbs'][] = ['label' => 'Destino Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-favorito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
