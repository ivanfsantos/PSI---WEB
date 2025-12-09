<?php

use common\models\Documento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\DocumentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Enviar Documentos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


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
