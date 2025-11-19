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

      $perfilExistente = Perfil::findOne(['user_id' => Yii::$app->user->id]);
      if(!$perfilExistente) { ?>

    <p>
        <?= Html::a('Create Perfil', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
          <?php
      }
      ?>



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
                            'template' => '{view} {update} {delete} {avaliar}',
                            'buttons' => [
                                    'view' => fn($url,$model) =>
                                    Html::a('Ver', $url, [
                                            'class' => 'btn btn-primary btn-sm',
                                            'style' => 'margin-right: 5px;'
                                    ]),

                                    'update' => fn($url,$model) =>
                                    Html::a('Editar', $url, [
                                            'class' => 'btn btn-warning btn-sm',
                                            'style' => 'margin-right: 5px;'
                                    ]),

                                    'delete' => fn($url,$model) =>
                                    Html::a('Eliminar', $url, [
                                            'class' => 'btn btn-danger btn-sm',
                                            'style' => 'margin-right: 5px;',
                                            'data-confirm' => 'Tem certeza?',
                                            'data-method' => 'post'
                                    ]),

                                    'avaliar' => fn($url,$model) =>
                                    Html::a('Avaliar', ['avaliacao/create','perfil_id' => $model->id], [
                                            'class' => 'btn btn-secondary btn-sm',
                                            'style' => 'margin-right: 5px;'
                                    ]),
                            ],

                            'urlCreator' => function ($action, Perfil $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                    ],
            ],
    ]); ?>



</div>
