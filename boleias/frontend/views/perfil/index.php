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
                 },
                'template' => '{view},{update},{delete},{documentos}',
                'buttons' => [
                        'documentos' => function ($url, $model, $key) {
                            if(Yii::$app->user->can('acederViatura')){

                                return Html::a('<i class="bi bi-archive">Docs</i>', Url::toRoute(['documento/create', 'id' => $model->id]));

                            }
                        }
                ]
            ],
    ]); ?>



</div>
