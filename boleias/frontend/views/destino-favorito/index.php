<?php

use common\models\DestinoFavorito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DestinoFavoritoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Destino Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-favorito-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'label'=>'Remover',
                'format'=>'raw',
                'value'=>function ($model) {
                    return Html::a(
                        '<i class="bi bi-trash"></i> Remover',
                        ['destino-favorito/delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tens a certeza que queres remover esta boleia da wishlist?',
                                'method' => 'post', //
                            ],
                        ]
                    );
                }

            ]
        ],
    ]); ?>




</div>
