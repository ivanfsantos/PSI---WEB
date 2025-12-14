<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/** @var yii\web\View $this */
/** @var array $boleias */
/** @var \common\models\Perfil $perfil */

$this->title = 'Boleias do Condutor';
$this->params['breadcrumbs'][] = $this->title;

// Converte array de boleias em ArrayDataProvider
$dataProvider = new ArrayDataProvider([
    'allModels' => $boleias,
    'pagination' => ['pageSize' => 10],
]);

?>

<div class="boleia-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [
                'origem',
                'destino',
                'data_hora',
                [
                    'label' => 'Lugares',
                    'value' => fn($model) => $model->lugares_disponiveis,
                ],
                [
                    'label' => 'Carro',
                    'value' => fn($model) => $model->viatura ? $model->viatura->modelo : '-',
                ],
                [
                    'attribute' => 'preco',
                    'label' => 'Preço',
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{watchlist} {reservar}',
                    'buttons' => [
                        'reservar' => fn($url, $model) =>
                        Html::a('Reservar', ['reserva/create', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']),
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
