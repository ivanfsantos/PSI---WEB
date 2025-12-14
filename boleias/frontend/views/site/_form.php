<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Boleia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="boleia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'origem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'destino')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_hora')->input('datetime-local')?>

    <?= $form->field($model, 'viatura_id')->dropDownList(
        ArrayHelper::map($viaturas, 'id', 'modelo'),
        ['prompt' => 'Selecione uma viatura']
)->label('Viaturas');?>

    <?= $form->field($model, 'preco')->input('number', ['step' => '0.01']) ?>

    <?= $form->field($model, 'lugares_disponiveis')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
