<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Documento $model */
/** @var common\models\UploadDocumentoCarta $modelUploadCarta */
/** @var common\models\UploadDocumentoCartao $modelUploadCartao */

$this->title = 'Update Documento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUploadCarta'=>$modelUploadCarta,
        'modelUploadCartao'=>$modelUploadCartao
    ]) ?>

</div>
