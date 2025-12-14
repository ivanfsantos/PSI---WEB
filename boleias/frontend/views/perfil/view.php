<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */

$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="perfil-view container py-4">

    <h1 class="mb-4 text-center"><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-center mb-4">
        <?= Html::a('Editar Perfil', ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-2']) ?>
        <?= Html::a('Apagar Perfil', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja apagar este perfil?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informações do Perfil</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nome:</strong>
                    <p class="text-muted"><?= Html::encode($model->nome) ?></p>
                </div>
                <div class="col-md-6">
                    <strong>Telefone:</strong>
                    <p class="text-muted"><?= Html::encode($model->telefone) ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Morada:</strong>
                    <p class="text-muted"><?= Html::encode($model->morada) ?></p>
                </div>
                <div class="col-md-6">
                    <strong>Género:</strong>
                    <p class="text-muted"><?= Html::encode($model->genero) ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <strong>Data de Nascimento:</strong>
                    <p class="text-muted"><?= Yii::$app->formatter->asDate($model->data_nascimento) ?></p>
                </div>
            </div>
        </div>
    </div>

</div>
