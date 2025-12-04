<?php

use common\models\Boleia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\BoleiaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boleias';
$this->params['breadcrumbs'][] = $this->title;
?>


    <?php
    use common\models\Perfil;
    $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);

    $buttons = [
        'delete' => function ($url, $model, $key) {
            return Html::a(
                '<i class="bi bi-trash"></i> Remover',
                ['site/delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Tem a certeza que deseja remover esta boleia?',
                        'method' => 'post',
                    ],
                ]
            );
        },

        'update' => function ($url, $model, $key) {
            return Html::a(
                '<i class="bi bi-pencil"></i> Editar',
                ['site/update', 'id' => $model->id],
                ['class' => 'btn btn-warning btn-sm']
            );
        },

        'reservar' => function ($url, $model, $key) {
            return Html::a(
                '<i class="bi bi-archive"></i> Reservar',
                ['reserva/create', 'id' => $model->id],
                ['class' => 'btn btn-primary btn-sm']
            );
        },

        'view' => function ($url, $model, $key) {
            return Html::a(
                '<i class="bi bi-eye"></i> Ver',
                ['site/view', 'id' => $model->id],
                ['class' => 'btn btn-info btn-sm']
            );
        },

    ];
    if($perfil && !$perfil->condutor){
        $buttons['wishlist'] = function ($url, $model, $key) {
            $jaExiste = count($model->destinosFavoritos);
            $texto = $jaExiste ? '<i class="bi bi-eye"></i> Remover WishList' : '<i class="bi bi-eye"></i> WishList';
            $class = $jaExiste ? 'btn btn-danger btn-sm' : 'btn btn-warning btn-sm';
            $actionconfig = $jaExiste ? ['destino-favorito/delete', 'id' => $model->destinosFavoritos[0]->id] : ['destino-favorito/create', 'boleia_id' => $model->id];
            $data = $jaExiste
                ? [
                    'method' => 'post',
                    'confirm' => 'Tens a certeza que queres remover esta boleia da tua wishlist?',
                ]
                : [];

            return Html::a(
                $texto,
                $actionconfig,
                ['class' => $class,
                    'data' =>$data]


            );
        };
    }
    ?>



<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Boleias</h1>
            <br>
            <?php
            if(Yii::$app->user->can('criarBoleia')){
                ?>
                <p><a class="btn btn-lg btn-success" href="site/create">Criar Boleia</a></p>
                <?php
            } ?>
        </div>
    </div>
</div>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card p-3 mb-5 bg-white border border-5 rounded-4">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'options' => ['class' => 'grid-view table-responsive'],
        'columns' => [
            'origem',
            'destino',
            'data_hora',
            [
                'attribute' => 'viatura_id',
                'label' => 'Lugares',
                'value' => function ($model) {
                    return $model->viatura->lugares_disponiveis;
                }
            ],
            [
                'attribute' => 'viatura_id',
                'label' => 'Carro',
                'value' => function ($model) {
                    return $model->viatura->modelo;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {reservar} {wishlist}', // adiciona wishlist
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return $model->viatura->perfil->user_id == Yii::$app->user->id;
                    },
                    'update' => function ($model, $key, $index) {
                        return $model->viatura->perfil->user_id == Yii::$app->user->id;
                    },
                    'reservar' => function ($model, $key, $index) {
                        return $model->viatura->perfil->user_id != Yii::$app->user->id
                            && $model->viatura->lugares_disponiveis > 0
                            && Yii::$app->user->can('acederBoleia');
                    },
                    'view' => function ($model, $key, $index) {
                        return true;
                    },
                    'wishlist' => function ($model, $key, $index) use ($perfil) {
                        return $perfil && !$perfil->condutor; // só mostra se perfil existe e não for condutor
                    },
                ],
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-trash"></i> Remover',
                            ['site/delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja remover esta boleia?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-pencil"></i> Editar',
                            ['site/update', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-sm']
                        );
                    },
                    'reservar' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-archive"></i> Reservar',
                            ['reserva/create', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-sm']
                        );
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-eye"></i> Ver',
                            ['site/view', 'id' => $model->id],
                            ['class' => 'btn btn-info btn-sm']
                        );
                    },
                    'wishlist' => function ($url, $model, $key) {
                        $jaExiste = count($model->destinosFavoritos) > 0;
                        $texto = $jaExiste ? '<i class="bi bi-heart-fill"></i> Remover Wishlist' : '<i class="bi bi-heart"></i> Add Wishlist';
                        $class = $jaExiste ? 'btn btn-danger btn-sm' : 'btn btn-warning btn-sm';

                        $actionConfig = $jaExiste
                            ? ['destino-favorito/delete', 'id' => $model->destinosFavoritos[0]->id ?? null]
                            : ['destino-favorito/create', 'boleia_id' => $model->id];

                        $data = $jaExiste
                            ? [
                                'method' => 'post',
                                'confirm' => 'Tens a certeza que queres remover esta boleia da tua wishlist?',
                            ]
                            : [];

                        if ($jaExiste && ($actionConfig['id'] === null)) {
                            return '';
                        }

                        return Html::a($texto, $actionConfig, ['class' => $class, 'data' => $data]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>


