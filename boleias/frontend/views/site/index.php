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

<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Boleias</h1>
            <br>
            <p><a class="btn btn-lg btn-success" href="site/create">Criar Boleia</a></p>

        </div>
    </div>
</div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'origem',
            'destino',
            'data_hora',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {favoritos}', // <- OBRIGATÓRIO
                'buttons' => [
                    'favoritos' => function ($url, $model) {
                        return Html::a('💚','site/add-favorito/'. $model->id);

                    },

                ],
                'urlCreator' => function ($action, Boleia $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>




