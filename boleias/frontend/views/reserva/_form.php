<?php

use common\models\CondutorFavorito;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Perfil;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="reserva-form d-flex gap-4">

    <div style="display: inline-block; width:50%; margin-top: 30px;">
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
        <br>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>


        <?php ActiveForm::end(); ?>


    </div>
    <div class="d-flex gap-2" style="width:50%;">
        <div>
            <img style="border-radius: 50%;;height: 180px;width:180px;object-fit:cover;" src="https://img.freepik.com/fotos-gratis/retrato-de-homem-branco-isolado_53876-40306.jpg?semt=ais_se_enriched&w=740&q=80" alt="">
        </div>
        <div>
            <h6>Nome: <?=$condutor->nome?></h6>
            <h6>Viagens Feitas:</h6>
            <h6>Avaliacao:</h6>

            <?php echo Html::a($texto_condutor,$rotaConfig,[
                    'class'=> $btn_class,
                    'data'=>['method' => 'post']
                    ]) ?>
        </div>
    </div>


</div>
