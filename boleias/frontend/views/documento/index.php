<?php

use common\models\Documento;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \common\models\DocumentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Enviar Documentos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="card p-3 mb-5 bg-white border border-5 rounded-4">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [

            [
                'attribute' => 'perfil_id',
                'value' => function ($model) {
                    return $model->perfil ? $model->perfil->nome : '(sem nome)';
                },
                'label' => 'Perfil',
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

                ],
            ],
        ],
    ]); ?>




</div>
