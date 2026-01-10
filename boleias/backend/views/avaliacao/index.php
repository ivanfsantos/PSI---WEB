<?php

use common\models\Avaliacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\AvaliacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card p-4 mb-5 bg-white border border-5 rounded-4 shadow-sm">

    <h2 class="mb-4 text-center"><?= Html::encode($this->title) ?></h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'tableOptions' => ['class' => 'table table-hover align-middle'],
        'columns' => [

            [
                'attribute' => 'descricao',
                'format' => 'ntext',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'perfil_id',
                'label' => 'Condutor',
                'value' => function($model) {
                    return $model->perfil ? $model->perfil->nome : '—';
                },
                'filter' => false,
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Ações',
                'template' => '{delete}', 
                'urlCreator' => function ($action, Avaliacao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [

                    'delete' => function($url, $model) {
                        return Html::a('<i class="bi bi-trash"></i> Apagar', $url, [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem certeza que deseja apagar esta avaliação?',
                                'method' => 'post',
                            ],
                            'title' => 'Apagar'
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .btn-sm {
        min-width: 90px;
    }
</style>
