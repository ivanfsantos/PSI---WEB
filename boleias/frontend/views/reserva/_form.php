<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'perfil_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'boleia_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'boleia_info')->textInput([
        'value' => $model->boleia ? $model->boleia->origem . ' -> ' . $model->boleia->destino : '',
        'readonly' => true
    ])->label('Boleia') ?>


    <!-- Campo de ponto de encontro -->
    <?= $form->field($model, 'ponto_encontro')->textarea([
        'rows' => 3,
        'placeholder' => 'Indique o ponto de encontro...'
    ])->label('Ponto de Encontro') ?>


    <!-- Campo de contacto -->
    <?= $form->field($model, 'contacto')->textInput([
        'type' => 'number',
        'placeholder' => 'Contacto telefónico'
    ])->label('Contacto') ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
