<?php

use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PerfilSearch $searchModel */
/** @var common\models\Perfil $perfilExistente */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php if(!$perfilExistente): ?>
        <p>
            <?= Html::a('Create Perfil', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
      <?php else: ?>
         <div class="container">
             <div class="row">
                 <div class="col-auto">
                     <?= Html::a('Ver Viaturas', ['viatura/index'], ['class' => 'btn btn-success']) ?>
                 </div>
                 <div class="col-auto">
                     <?= Html::a('Enviar Documentos', ['documento/create'], ['class' => 'btn btn-success']) ?>
                 </div>
             </div>
         </div>
    <?php endif; ?>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'nome',
            'telefone',
            'morada',
            'genero',
            'data_nascimento',
            'condutor',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Perfil $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
