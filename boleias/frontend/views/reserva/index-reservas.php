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

    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [
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
                'ponto_encontro',
                'contacto',
                'estado',
                'reembolso'
            ],
        ]);
        ?>

        <p>
            <?= Html::a('Validar Reservas', ['validar', 'id' => $boleia_id], ['class' => 'btn btn-success']) ?>

        </p>

    </div>


</div>
