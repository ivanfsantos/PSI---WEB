<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */
/** @var common\models\Avaliacao[] $avaliacoes */

$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="perfil-view container py-4">

    <h1 class="mb-4 text-center"><?= Html::encode($this->title) ?></h1>


    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informações do Perfil</h4>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nome',
                    'telefone',
                    'morada',
                    'genero',
                    [
                        'attribute' => 'data_nascimento',
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                ],
                'options' => ['class' => 'table table-borderless mb-0'],
            ]) ?>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0"><i class="bi bi-star-fill me-2"></i>Avaliações</h4>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($avaliacoes)): ?>
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Descrição</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($avaliacoes as $avaliacao): ?>
                        <tr>
                            <td><?= Html::encode($avaliacao->descricao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="p-3 text-muted mb-0">Não há avaliações para este perfil.</p>
            <?php endif; ?>
        </div>
    </div>

</div>
