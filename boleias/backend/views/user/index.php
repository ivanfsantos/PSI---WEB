<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            'username',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {avaliacoes} {toggle-status}',
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-eye"></i> Ver',
                            $url,
                            ['class' => 'btn btn-info btn-sm']
                        );
                    },
                    'avaliacoes' => function ($url, $model, $key) {

                    if ($model->perfil !== null) {
                        return Html::a(
                            '<i class="bi bi-star"></i> Gerir Avaliações',
                            ['user/perfil', 'id' => $model->id],
                            ['class' => 'btn btn-success btn-sm']
                        );
                    }
                        
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-pencil"></i> Editar',
                            $url,
                            ['class' => 'btn btn-warning btn-sm']
                        );
                    },
                    'toggle-status' => function ($url, $model, $key) {
                        if ($model->status == 9) {
                            return Html::a(
                                '<i class="bi bi-check-circle"></i> Reativar',
                                ['reactivate', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => [
                                        'confirm' => 'Tem a certeza que deseja reativar este utilizador?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        } else {
                            return Html::a(
                                '<i class="bi bi-slash-circle"></i> Desativar',
                                ['deactivate', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Tem a certeza que deseja desativar este utilizador?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        }
                    },
                ],
            ],
        ],
    ]); ?>
    <br>
        <p>
            <?= Html::a('Create Admin', ['user/signup'], ['class' => 'btn btn-success']) ?>
        </p>


    </div>