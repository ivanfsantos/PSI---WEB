<?php

use common\models\DestinoFavorito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DestinoFavoritoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Watchlist';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-favorito-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
             [
                'label' => 'Origem',
                'value' => function ($model) {
                    return $model->boleia ? $model->boleia->origem : '—';
                }
            ],
            [
                'label' => 'Destino',
                'value' => function ($model) {
                    return $model->boleia ? $model->boleia->destino : '—';
                }
            ],
            [
                'label' => 'Data',
                'value' => function ($model) {
                    return $model->boleia ? date('d/m/Y', strtotime($model->boleia->data_hora)) : '—';
                }
            ],
            [
                'label' => 'Hora',
                'value' => function ($model) {
                    return $model->boleia ? date('H:i', strtotime($model->boleia->data_hora)) : '—';
                }
            ],
            [
                'label' => 'Ações',
                'format' => 'raw',
                'value' => function ($model) {
                    $buttons = '';

                    // Botão Remover
                    $buttons .= Html::a(
                        '<i class="bi bi-trash"></i> Remover',
                        ['destino-favorito/delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger btn-sm me-1',
                            'data' => [
                                'confirm' => 'Tens a certeza que queres remover esta boleia da wishlist?',
                                'method' => 'post',
                            ],
                        ]
                    );

                    if ($model->boleia) {
                        $perfil = \common\models\Perfil::findOne(['user_id' => Yii::$app->user->id]);

                        if ($perfil) {
                            // Aqui consultamos diretamente a tabela Reserva
                            $reservaExistente = \common\models\Reserva::find()
                                ->where([
                                    'boleia_id' => $model->boleia->id,
                                    'perfil_id' => $perfil->id,
                                ])
                                ->exists();

                            if (!$reservaExistente) {
                                // Mostra botão de reservar
                                $buttons .= Html::a(
                                    '<i class="bi bi-check-circle"></i> Reservar',
                                    ['reserva/create', 'id' => $model->boleia->id],
                                    [
                                        'class' => 'btn btn-success btn-sm',
                                        'title' => 'Criar reserva',
                                        'data' => ['method' => 'post'],
                                    ]
                                );
                            } else {
                                // Opcional: mostra "Reservado" ou apenas esconde o botão
                                $buttons .= Html::tag('span', 'Reservado', [
                                    'class' => 'btn btn-secondary btn-sm disabled'
                                ]);
                            }
                        }
                    }

                    return $buttons;
                },
            ],

        ],
    ]); ?>


</div>

</div>
