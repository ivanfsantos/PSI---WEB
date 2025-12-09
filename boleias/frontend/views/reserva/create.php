<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */

$this->title = 'Create Reserva';
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'perfil_id' => $perfil_id,
        'boleia_id' => $boleia_id,
        'texto_condutor'=>$texto_condutor,
        'condutor' => $condutor,
        'rotaConfig'=>$rotaConfig,
        'btn_class'=>$btn_class,

    ]) ?>

</div>
