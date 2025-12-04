<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Documento $model */

$this->title = "Documento #" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="documento-view container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mb-3">
        <strong>Estado:</strong>
        <?php if ($model->valido): ?>
            <span class="badge bg-success">Validado</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Pendente</span>
        <?php endif; ?>
    </div>

    <div class="row">

        <!-- Carta de Condução -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    Carta de Condução
                </div>
                <div class="card-body text-center">

                    <?php if ($model->carta_conducao): ?>
                        <img src="<?= 'uploads/'. $model->carta_conducao ?>"
                             alt="Carta de Condução"
                             class="img-fluid rounded"
                             style="max-height: 350px; border: 1px solid #ddd;">


                    <?php else: ?>
                        <p class="text-muted">Nenhuma imagem enviada.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Cartão de Cidadão -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Cartão de Cidadão
                </div>
                <div class="card-body text-center">

                    <?php if ($model->cartao_cidadao): ?>
                        <img src="<?= 'uploads/'. $model->cartao_cidadao ?>"
                             alt="Cartão de Cidadão"
                             class="img-fluid rounded"
                             style="max-height: 350px; border: 1px solid #ddd;">
                    <?php else: ?>
                        <p class="text-muted">Nenhuma imagem enviada.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

    <!-- Informação do Documento -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'perfil_id',
                'label' => 'Nome',
                'value' => $model->perfil->nome ?? 'Perfil não encontrado',
            ],

            [
                'attribute' => 'valido',
                'value' => $model->valido ? 'Validado' : 'Pendente',
            ],
        ],
    ]) ?>

</div>
