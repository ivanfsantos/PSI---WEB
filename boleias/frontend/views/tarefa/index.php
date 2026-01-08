<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $tarefas common\models\Tarefa[] */

$this->title = 'Tarefas';
?>

<h1>Tarefas</h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Estado</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tarefas as $tarefa): ?>
        <tr>
            <td><?= $tarefa->id ?></td>
            <td><?= Html::encode($tarefa->titulo) ?></td>
            <td><?= Html::encode($tarefa->descricao) ?></td>
            <td><?= Html::encode($tarefa->displayEstado()) ?></td>
            <td>
                <?= Html::beginForm(['/tarefa/update-estado', 'id' => $tarefa->id], 'post') ?>
                <?= Html::dropDownList('estado', $tarefa->estado, $tarefa::optsEstado(), ['class' => 'form-control']) ?>
                <?= Html::submitButton('Atualizar', ['class' => 'btn btn-sm btn-primary mt-1']) ?>
                <?= Html::endForm() ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
