<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view container py-4">

    <h1 class="mb-4 text-center"><?= Html::encode($this->title) ?></h1>

    <div class="text-center mb-4">
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-lg me-2']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-lg',
            'data' => [
                'confirm' => 'Tem certeza que deseja apagar este utilizador?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px; border-radius: 12px;">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'email:email',
                [
                    'attribute' => 'status',
                    'value' => function($model) {
                        return $model->status == 10 ? 'Ativo' : 'Inativo';
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d/m/Y H:i'],
                ],
            ],
            'options' => ['class' => 'table table-borderless mb-0'],
        ]) ?>
    </div>

</div>



<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        text-align: center;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
