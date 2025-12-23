<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Boleia $model */

$this->params['breadcrumbs'][] = ['label' => 'Boleias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="boleia-view container py-4">

    <h1 class="mb-4 text-center"><?= Html::encode($this->title) ?></h1>

    <div class="mb-4 d-flex justify-content-center">
        <?= Html::a('Editar Boleia', ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-2']) ?>
        <?= Html::a('Apagar Boleia', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja apagar esta boleia?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-car-front-fill me-2"></i>Detalhes da Boleia</h4>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'origem',
                    'destino',
                    [
                        'attribute' => 'data_hora',
                        'format' => ['datetime', 'php:d/m/Y H:i'],
                    ],
                    [
                        'attribute' => 'preco',
                    ],
                    [
                        'label' => 'Lugares Disponíveis',
                        'value' => fn($model) => $model->lugares_disponiveis,
                    ],
                    [
                        'label' => 'Viatura',
                        'value' => fn($model) => $model->viatura ? $model->viatura->modelo : '-',
                    ],
                ],
                'options' => ['class' => 'table table-borderless mb-0'],
            ]) ?>
        </div>
    </div>

</div>
