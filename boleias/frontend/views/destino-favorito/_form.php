<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DestinoFavorito $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="destino-favorito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo')->dropDownList([
        'origem' => 'Origem',
        'destino' => 'Destino',
    ], ['prompt' => 'Escolha o tipo']) ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
