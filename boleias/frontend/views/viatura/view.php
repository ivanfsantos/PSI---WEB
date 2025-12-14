<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Viatura $model */

$this->params['breadcrumbs'][] = ['label' => 'Viaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="viatura-view container py-4">

    <h1 class="mb-4 text-center"><?= Html::encode($this->title) ?></h1>

    <div class="mb-4 d-flex justify-content-center">
        <?= Html::a('Editar Viatura', ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-2']) ?>
        <?= Html::a('Apagar Viatura', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja apagar esta viatura?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0"><i class="bi bi-car-front-fill me-2"></i>Detalhes da Viatura</h4>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'marca',
                    'modelo',
                    'matricula',
                    'cor',
                ],
                'options' => ['class' => 'table table-borderless mb-0'],
            ]) ?>
        </div>
    </div>

</div>
