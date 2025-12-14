<?php

use common\models\Documento;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \common\models\DocumentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [

            [
                'label' => 'Docs', // coluna de numeração
                'value' => function($model, $key, $index, $column) {
                    return $index + 1; // $index começa em 0, então somamos 1
                },
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{ver} {validar}',   // <-- CORRIGIDO AQUI
                'urlCreator' => function ($action, Documento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [
                    'ver' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-eye"></i> Ver Documentos',
                            ['documento/view', 'id' => $model->id],
                            [
                                'class' => 'btn btn-info btn-sm',
                            ]
                        );
                    },
                    'validar' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-check-circle"></i> Validar',
                            ['documento/validate', 'id' => $model->id],   // <-- confirmo que deve ser "validar", não "validate"
                            [
                                'class' => 'btn btn-success btn-sm',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Tem a certeza que deseja validar este documento?',
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
