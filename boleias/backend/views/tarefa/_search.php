<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TarefaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'criador') ?>

    <?= $form->field($model, 'atribuido') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'data_criacao') ?>

    <?php // echo $form->field($model, 'data_atualizacao') ?>

    <?php // echo $form->field($model, 'data_confirmacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
