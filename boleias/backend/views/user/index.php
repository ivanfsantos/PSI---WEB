<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Admin', ['user/signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '', // Add this line to hide the summary text
        'columns' => [
            'username',

            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}', // Explicitly define standard buttons
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    // Ensures the URL points correctly to the User controller actions
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
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-pencil"></i> Editar',
                            $url,
                            ['class' => 'btn btn-warning btn-sm']
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-trash"></i> Remover',
                            $url,
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja remover este utilizador?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
    </div>

</div>
