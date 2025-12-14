<?php

use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PerfilSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    $perfil = Perfil::findOne(['user_id' => Yii::$app->user->id]);
    if(!$perfil) { ?>

        <p>
            <?= Html::a('Create Perfil', ['create'], ['class' => 'btn btn-success']) ?>

        </p>
        <?php
    } else { ?>
        <p>
            <?php

            if(Yii::$app->user->can('acederViatura')){
                echo Html::a('Ver Viaturas', ['viatura/index', 'id' => $perfil->id], ['class' => 'btn btn-success']);
            }
            ?>



        </p>
        <?php
    }
    ?>





    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [
                'nome',
                'telefone',
                'morada',
                'genero',
                'data_nascimento',
                [
                    'attribute' => 'condutor',
                    'label' => 'Condutor',
                    'value' => function($model) {
                        return $model->condutor ? 'Sim' : 'Não';
                    },
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Perfil $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    // Add spaces between the actions here
                    'template' => '{view} {update} {delete} {documentos}',
                    'buttons' => [
                        'view' => function ($url) {
                            // View button with 'info' color and icon
                            return Html::a('<i class="bi bi-eye">Ver</i>', $url, ['class' => 'btn btn-info btn-sm', 'title' => 'View']);
                        },
                        'update' => function ($url) {
                            // Update button with 'primary' color and icon
                            return Html::a('<i class="bi bi-pencil">Editar</i>', $url, ['class' => 'btn btn-primary btn-sm', 'title' => 'Update']);
                        },
                        'delete' => function ($url) {
                            // Delete button with 'danger' color and icon
                            return Html::a('<i class="bi bi-trash">Delete</i>', $url, [
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Delete',
                                'data-confirm' => 'Are you sure you want to delete this item?',
                                'data-method' => 'post',
                            ]);
                        },
                        'documentos' => function ($url, $model, $key) {
                            if(Yii::$app->user->can('acederViatura')){
                                // Docs button with 'secondary' color and icon
                                return Html::a('<i class="bi bi-archive"></i> Docs', Url::toRoute(['documento/index', 'id' => $model->id]), ['class' => 'btn btn-secondary btn-sm', 'title' => 'Manage Documents']);
                            }
                            return ''; // Return empty string if user cannot access
                        }
                    ]
                ],
            ],
        ]); ?>

    </div>
</div>
