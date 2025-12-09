<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Documento $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\UploadDocumentoCarta $modelUploadCarta */
/** @var common\models\UploadDocumentoCartao $modelUploadCartao */
?>

<div class="documento-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($modelUploadCarta, 'cartaFile')->fileInput() ?><br>

    <?= $form->field($modelUploadCartao, 'cartaoFile')->fileInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
