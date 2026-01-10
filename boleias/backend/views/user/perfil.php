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
        <th class="text-end">Ações</th> <!-- Added header -->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($avaliacoes as $avaliacao): ?>
        <tr>
            <td><?= Html::encode($avaliacao->descricao) ?></td>
            <td class="text-end"> <!-- Added button cell -->
                <?= Html::a('<i class="bi bi-trash"></i> Remover', 
                    ['user/avaliacao-delete', 'id' => $avaliacao->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Tem a certeza que deseja remover esta avaliação?',
                        'method' => 'post',
                    ],
                ]) ?>
            </td>
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
