<?php

use common\models\CondutorFavorito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CondutorFavoritoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Condutores Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condutor-favorito-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [

                [
                    'attribute' => 'perfil_id_condutor',
                    'label' => 'Nome do Condutor',
                    'value' => function($model) {
                        return $model->condutorPerfil ? $model->condutorPerfil->nome : '—';
                    },
                ],

                [
                    'class' => ActionColumn::className(),
                    'template' => '{cancel} {ver-boleias} {ver-perfil}',
                    'buttons' => [
                        'cancel' => function($url, $model) {
                            return Html::a(
                                'Cancelar',
                                ['condutor-favorito/delete', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Tem certeza que deseja remover este condutor dos favoritos?',
                                ]
                            );
                        },

                        'ver-boleias' => function($url, $model) {
                            return Html::a(
                                'Ver Boleias',
                                ['condutor-favorito/boleias', 'id' => $model->perfil_id_condutor],
                                [
                                    'class' => 'btn btn-info btn-sm',
                                ]
                            );
                        },

                        'ver-perfil' => function ($url, $model) {
                            return Html::a('<i class="bi bi-eye"></i> Ver Perfil',
                                ['perfil/perfil', 'id' => $model->perfil_id_condutor],
                                ['class' => 'btn btn-info btn-sm']);
                        },
                    ],
                ],
            ],
        ]); ?>



    </div>
