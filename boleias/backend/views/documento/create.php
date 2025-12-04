<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Documento $model */
/** @var common\models\UploadDocumentoCarta $modelUploadCarta */
/** @var common\models\UploadDocumentoCartao $modelUploadCartao */
/** @var string $message */

$this->title = 'Create Documento';
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($message != ""): ?>

    <div class="alert alert-success"> <?=$message?></div>

    <?php endif;?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUploadCarta'=>$modelUploadCarta,
        'modelUploadCartao'=>$modelUploadCartao

    ]) ?>

</div>
