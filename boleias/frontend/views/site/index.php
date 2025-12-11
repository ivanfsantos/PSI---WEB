<?php

use common\models\Boleia;
use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\BoleiaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boleias';
$this->params['breadcrumbs'][] = $this->title;

$perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
?>

<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Boleias</h1>
            <br>
            <?php if(Yii::$app->user->can('criarBoleia')): ?>
                <p><a class="btn btn-lg btn-success" href="<?= Url::to(['site/create']) ?>">Criar Boleia</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>

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
                'label' => 'Lugares',
                'value' => function ($model) {
                    return $model->lugares_disponiveis;
                }
            ],
            [
                'label' => 'Carro',
                'value' => function ($model) {
                    return $model->viatura ? $model->viatura->modelo : '-';
                }
            ],
            [
                'attribute' => 'preco',
                'label' => 'Preço',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {reservar} {wishlist} {ver-reservas}',
                'visibleButtons' => [
                    'delete' => function ($model) use ($perfil) {
                        return !$model->isFechada() && $perfil && $model->viatura && $model->viatura->perfil->user_id == $perfil->user_id;
                    },
                    'update' => function ($model) use ($perfil) {
                        return !$model->isFechada() && $perfil && $model->viatura && $model->viatura->perfil->user_id == $perfil->user_id;
                    },
                    'reservar' => function ($model) use ($perfil) {
                        return !$model->isFechada() && $perfil && $model->viatura && $model->viatura->perfil->user_id != $perfil->user_id
                            && $model->lugares_disponiveis > 0
                            && Yii::$app->user->can('acederBoleia');
                    },
                    'view' => function () {
                        return true; // sempre visível, mas o botão muda se estiver fechada
                    },
                    'wishlist' => function ($model) use ($perfil) {
                        return !$model->isFechada() && $perfil && !$perfil->condutor;
                    },
                    'ver-reservas' => function ($model) use ($perfil) {
                        return !$model->isFechada() && $perfil && $model->viatura && $model->viatura->perfil_id == $perfil->id;
                    },
                ],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        if ($model->isFechada()) {
                            return '<span class="text-muted">Boleia Fechada</span>';
                        }
                        return Html::a('<i class="bi bi-eye"></i> Ver', ['site/view', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']);
                    },
                    'delete' => function ($url, $model, $key) {
                        if ($model->isFechada()) return '';
                        return Html::a('<i class="bi bi-trash"></i> Remover', ['site/delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem a certeza que deseja remover esta boleia?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        if ($model->isFechada()) return '';
                        return Html::a('<i class="bi bi-pencil"></i> Editar', ['site/update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']);
                    },
                    'reservar' => function ($url, $model, $key) {
                        if ($model->isFechada()) return '';
                        return Html::a('<i class="bi bi-archive"></i> Reservar', ['reserva/create', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                    },
                    'wishlist' => function ($url, $model, $key) use ($perfil) {
                        if ($model->isFechada() || !$perfil) return '';
                        $favorito = $model->getDestinosFavoritos()->andWhere(['perfil_id' => $perfil->id])->one();
                        $jaExiste = $favorito !== null;
                        $texto = $jaExiste ? '<i class="bi bi-heart-fill"></i> Remover Watchlist' : '<i class="bi bi-heart"></i> Add Watchlist';
                        $class = $jaExiste ? 'btn btn-danger btn-sm' : 'btn btn-warning btn-sm';
                        $actionConfig = $jaExiste ? ['destino-favorito/delete', 'id' => $favorito->id] : ['destino-favorito/create', 'boleia_id' => $model->id];
                        $data = $jaExiste ? ['method' => 'post', 'confirm' => 'Tens a certeza que queres remover esta boleia da tua wishlist?'] : [];
                        return Html::a($texto, $actionConfig, ['class' => $class, 'data' => $data]);
                    },
                    'ver-reservas' => function ($url, $model, $key) {
                        if ($model->isFechada()) return '';
                        return Html::a('<i class="bi bi-list-check"></i> Ver Reservas', ['reserva/reservas', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']);
                    },
                ],
            ],

        ],
    ]); ?>
</div>
