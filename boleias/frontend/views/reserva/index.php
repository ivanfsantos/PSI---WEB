<?php

use common\models\Reserva;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ReservaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                        return $model->boleia ? $model->boleia->data_hora : '(sem horário)';
                    }
                ],
                'ponto_encontro',
                'contacto',
                'reembolso',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{cancel} {add-condutor} {fazer-avaliacao}',
                    'buttons' => [
                        'cancel' => function ($url, $model) {
                            if ($model->estado === 'Pago') {
                                return Html::tag('span', 'Reserva Validada', [
                                    'class' => 'btn btn-secondary btn-sm disabled'
                                ]);
                            }

                            return Html::a(
                                'Cancelar',
                                ['reserva/delete', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Tem certeza que deseja cancelar esta reserva?',
                                ]
                            );
                        },

                        'add-condutor' => function($url, $model) {
                            $condutorId = $model->boleia->viatura->perfil->id ?? null;
                            if ($condutorId) {
                                return Html::a(
                                    '<i class="bi bi-check-circle"></i> Add Condutor',
                                    ['condutor-favorito/create', 'id' => $condutorId],
                                    ['class' => 'btn btn-success btn-sm']
                                );
                            }
                            return '';
                        },

                        'fazer-avaliacao' => function ($url, $model) {
                            $condutorId = $model->boleia->viatura->perfil->id ?? null;
                            if ($condutorId) {
                                return Html::a(
                                    '<i class="bi bi-check-circle"></i> Avaliar Condutor',
                                    ['avaliacao/create', 'id' => $condutorId],
                                    ['class' => 'btn btn-info btn-sm']
                                );
                            }
                            return '';
                        }

                    ]
                ],
            ],
        ]); ?>

    </div>

</div>
