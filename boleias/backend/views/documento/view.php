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

    <p>
        <?= Html::a('Validar', ['documento/validate', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
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
                <div class="card-header bg-primary text-white">Carta de Condução</div>
                <div class="card-body text-center">
                    <?php
                    $cartaPath = '../../frontend/web/uploads/' . $model->carta_conducao;
                    if ($model->carta_conducao && file_exists($cartaPath)) {
                        $time = filemtime($cartaPath);
                        echo '<img src="' . $cartaPath . '?v=' . $time . '" alt="Carta de Condução" class="img-fluid rounded" style="max-height:350px; border:1px solid #ddd;">';
                    } else {
                        echo '<p class="text-muted">Nenhuma imagem enviada.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Cartão de Cidadão -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white">Cartão de Cidadão</div>
                <div class="card-body text-center">
                    <?php
                    $cartaoPath = '../../frontend/web/uploads/' . $model->cartao_cidadao;
                    if ($model->cartao_cidadao && file_exists($cartaoPath)) {
                        $time = filemtime($cartaoPath);
                        echo '<img src="' . $cartaoPath . '?v=' . $time . '" alt="Cartão de Cidadão" class="img-fluid rounded" style="max-height:350px; border:1px solid #ddd;">';
                    } else {
                        echo '<p class="text-muted">Nenhuma imagem enviada.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

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
    ```

</div>
