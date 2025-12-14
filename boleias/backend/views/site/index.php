<?php

/** @var yii\web\View $this */

use yii\grid\GridView;

$this->title = 'My Yii Application';

$user = \Yii::$app->user->getIdentity();
$nome = ($user && $user->perfil && $user->perfil->nome) ? $user->perfil->nome : ($user ? $user->username : 'Administrador');


?>
<div class="site-index">

    <br>

    <div class="d-flex justify-content-center">
        <h1>Bem-vindo <?= $nome ?></h1>
    </div>

    <br>

</div>

<div class="row">
    <div class="col-md-6 text-center">
        <a href="<?= Yii::$app->urlManager->createUrl(['documento/index']) ?>" class="card p-5 shadow-sm">
            <i class="fas fa-car fa-6x mb-3 text-primary"></i>
            <h3>Gestão de Documentos</h3>
            <p>Por validar: <?php echo $qtdDocumentosPendentes; ?> </p>
        </a>
    </div>

    <div class="col-md-6 text-center">
        <a href="<?= Yii::$app->urlManager->createUrl(['user/index']) ?>" class="card p-5 shadow-sm">
            <i class="fas fa-users fa-6x mb-3 text-success"></i>
            <h3>Gestão de Utilizadores</h3>
            <p>Users Registados: <?php echo $qtdUsersRegisto; ?></p>
        </a>
    </div>


    <div class="row justify-content-center mt-5">
        <div class="col-md-4 text-center">
            <a href="<?= Yii::$app->urlManager->createUrl(['avaliacao/index']) ?>" class="card p-5 shadow-sm mx-auto d-block">
                <i class="fas fa-star fa-6x mb-3 text-warning"></i>
                <h3>Avaliações</h3>
                <p>Avaliações feitas: <?php echo $qtdAvaliacoes; ?></p>            </a>
        </div>
    </div>

    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 12px;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .card::after {
            content: '';
            position: absolute;
            bottom: -20px; /* empurra para fora da base */
            left: 50%;
            transform: translateX(-50%) rotate(45deg); /* cria o triângulo invertido */
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            z-index: 0;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>

</div>

<style>
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>

