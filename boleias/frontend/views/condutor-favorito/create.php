<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CondutorFavorito $model */

$this->title = 'Create Condutor Favorito';
$this->params['breadcrumbs'][] = ['label' => 'Condutor Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condutor-favorito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
