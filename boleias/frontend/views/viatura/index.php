<?php

use common\models\Viatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ViaturaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Viaturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="viatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Viatura', ['create','id' =>$id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [
                'marca',
                'modelo',
                'matricula',
                'cor',
                'lugares_disponiveis',
                //'perfil_id',
                [
                    'class' => ActionColumn::className(),
                    // Ensure buttons are spaced correctly in the default template
                    'template' => '{view} {update} {delete}',
                    'urlCreator' => function ($action, Viatura $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    // Define the rendering for each default button
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
                    ],
                ],
            ],
        ]); ?>
    </div>

</div>
