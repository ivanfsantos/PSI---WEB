<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="avaliacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'boleia_id')->textInput() ?>

    <?php
    use common\models\Perfil;
    $perfil = Perfil::findOne($model->perfil_id);
    ?>

    <?= $form->field($model, 'perfil_id')->hiddenInput()->label(false) ?>

    <label>Perfil</label>
    <input type="text"
           class="form-control"
           value="<?= $perfil ? $perfil->nome : '' ?>"
           readonly>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
