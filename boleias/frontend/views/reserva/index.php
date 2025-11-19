<?php

use common\models\Reserva;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ReservaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'estado',
            [
                'label' => 'Origem',
                'value' => function($model) {
                    return $model->boleia ? $model->boleia->origem : '(sem origem)';
                }
            ],
            [
                'label' => 'Destino',
                'value' => function($model) {
                    return $model->boleia ? $model->boleia->destino : '(sem destino)';
                }
            ],
            [
                'label' => 'Data/Hora',
                'value' => function($model) {
                    return $model->boleia ? $model->boleia->data_hora : '(sem horario)';
                }
            ],

            // ✔ CUSTOM ACTION COLUMN HERE
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{cancel}',
                'buttons' => [
                    'cancel' => function ($url, $model) {
                        return Html::a(
                            'Cancelar',
                            ['reserva/delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'data-method' => 'post',
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>



</div>
