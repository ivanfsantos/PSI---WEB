<?php

use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\BoleiaSearch $searchModel */

$this->title = 'Boleias';
$this->params['breadcrumbs'][] = $this->title;

$perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
?>

<div class="site-index">

    <!-- Header -->
    <div class="p-5 mb-4 bg-transparent rounded-3 text-center">
        <h1 class="display-4">Boleias</h1>

        <?php if (Yii::$app->user->can('criarBoleia')): ?>
            <p class="mt-4">
                <?= Html::a(
                    '<i class="bi bi-plus-circle"></i> Criar Boleia',
                    ['site/create'],
                    ['class' => 'btn btn-success btn-lg']
                ) ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Grid -->
    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => '',
            'rowOptions' => function($model) {
                return $model->isFechada() ? ['class' => 'table-warning'] : ['class' => 'table-success'];
            },
            'options' => ['class' => 'grid-view table-responsive'],
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
                    'label' => 'Preço (€)',
                ],

                [
                    'class' => ActionColumn::class,
                    'template' => '{reservar} {ver-reservas} {ver-perfil} {wishlist} {update} {delete}',

                    'visibleButtons' => [
                        'delete' => fn($model) =>
                            !$model->isFechada() &&
                            $perfil &&
                            $model->viatura &&
                            $model->viatura->perfil->user_id == $perfil->user_id,

                        'update' => fn($model) =>
                            !$model->isFechada() &&
                            $perfil &&
                            $model->viatura &&
                            $model->viatura->perfil->user_id == $perfil->user_id,

                        'reservar' => fn($model) =>
                            !$model->isFechada() &&
                            $perfil &&
                            $model->viatura &&
                            $model->viatura->perfil->user_id != $perfil->user_id &&
                            $model->lugares_disponiveis > 0 &&
                            Yii::$app->user->can('acederBoleia'),

                        'wishlist' => fn($model) =>
                            !$model->isFechada() &&
                            $perfil &&
                            !$perfil->condutor,

                        'ver-reservas' => fn($model) =>
                            $perfil &&
                            $model->viatura &&
                            $model->viatura->perfil_id == $perfil->id,
                    ],

                    'buttons' => [

                        'ver-perfil' => fn($url, $model) =>
                        Html::a(
                            '<i class="bi bi-person"></i> Perfil',
                            ['perfil/perfil', 'id' => $model->viatura->perfil_id],
                            ['class' => 'btn btn-info btn-sm me-1 mb-1']
                        ),

                        'reservar' => fn($url, $model) =>
                        !$model->isFechada() ? Html::a(
                            '<i class="bi bi-ticket-perforated"></i> Reservar',
                            ['reserva/create', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-sm me-1 mb-1']
                        ) : '',

                        'wishlist' => function ($url, $model) use ($perfil) {
                            if ($model->isFechada() || !$perfil) return '';

                            $favorito = $model->getDestinosFavoritos()
                                ->andWhere(['perfil_id' => $perfil->id])
                                ->one();

                            $jaExiste = $favorito !== null;

                            return Html::a(
                                $jaExiste
                                    ? '<i class="bi bi-heart-fill"></i> Remover'
                                    : '<i class="bi bi-heart"></i> Wishlist',
                                $jaExiste
                                    ? ['destino-favorito/delete', 'id' => $favorito->id]
                                    : ['destino-favorito/create', 'boleia_id' => $model->id],
                                [
                                    'class' => $jaExiste ? 'btn btn-danger btn-sm me-1 mb-1' : 'btn btn-warning btn-sm me-1 mb-1',
                                    'data' => $jaExiste ? ['method' => 'post', 'confirm' => 'Remover da wishlist?'] : [],
                                ]
                            );
                        },

                        'ver-reservas' => fn($url, $model) =>
                        Html::a(
                            '<i class="bi bi-list-check"></i> Reservas',
                            ['reserva/reservas', 'id' => $model->id],
                            ['class' => 'btn btn-secondary btn-sm me-1 mb-1']
                        ),

                        'update' => fn($url, $model) =>
                        !$model->isFechada() ? Html::a(
                            '<i class="bi bi-pencil"></i> Editar',
                            ['site/update', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-sm me-1 mb-1']
                        ) : '',

                        'delete' => fn($url, $model) =>
                        !$model->isFechada() ? Html::a(
                            '<i class="bi bi-trash"></i> Remover',
                            ['site/delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-sm me-1 mb-1',
                                'data' => ['confirm' => 'Tem a certeza?', 'method' => 'post'],


                            ]
                        ) : '',
                    ],
                ],
            ],
        ]); ?>

    </div>
</div>
