<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;


/** @var yii\web\View $this */
/** @var common\models\Tarefa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'atribuido')->dropDownList(
            ArrayHelper::map(
                    User::find()->all(),
                    'id',
                    'username'
            ),
            ['prompt' => 'Selecionar utilizador']
    ) ?>

    <?php
    // Só o admin pode definir estado manualmente
    if (Yii::$app->user->can('admin')) {
        echo $form->field($model, 'estado')->dropDownList([
                'espera' => 'Espera',
                'confirmado' => 'Confirmado',
                'feito' => 'Feito',
        ]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

