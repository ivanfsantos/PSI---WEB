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
        <?= Html::a('Create Viatura', ['create','id' =>$id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'marca',
            'modelo',
            'matricula',
            'cor',
            'lugares_disponiveis',
            //'perfil_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Viatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
