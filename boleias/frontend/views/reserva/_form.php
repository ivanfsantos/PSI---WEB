<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'estado')->textInput([
        'value' => $model->estado,
        'readonly' => true
    ]) ?>

    <?= $form->field($model, 'perfil_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'boleia_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'boleia_info')->textInput([
        'value' => $model->boleia ? $model->boleia->origem . ' -> ' . $model->boleia->destino : '',
        'readonly' => true
    ])->label('Boleia') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
