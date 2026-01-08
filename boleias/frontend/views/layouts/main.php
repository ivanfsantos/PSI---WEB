<?php
/** @var \yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Alert;

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <base href="<?= Url::to('@web') ?>/">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title ?: 'Boleias') ?></title>

    <!-- Favicon -->
    <link href="htmlcodex/img/favicon.ico" rel="icon">


    <link rel="stylesheet" href="htmlcodex/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= Url::to('@web/css/site.css') ?>">

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="<?= Url::to(['/site/index']) ?>" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary">Boleias</h2>
    </a>
    <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>


            <?php if (Yii::$app->user->isGuest): ?>
                <a href="<?= Url::to(['/site/login']) ?>" class="nav-item nav-link">Login</a>
                <a href="<?= Url::to(['/site/signup']) ?>" class="nav-item nav-link">Signup</a>
            <?php else: ?>
                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="<?= Url::to(['/perfil/index','id' => Yii::$app->user->id]) ?>" class="nav-item nav-link">Perfil</a>



            <a href="<?= Url::to(['/reserva/index','id' => Yii::$app->user->id]) ?>" class="nav-item nav-link">Reservas</a>
            <a href="<?= Url::to(['/destino-favorito/index','id' => Yii::$app->user->id]) ?>" class="nav-item nav-link">Watchlist</a>
            <a href="<?= Url::to(['/condutor-favorito/index','id' => Yii::$app->user->id]) ?>" class="nav-item nav-link">Condutores</a>
            <a href="<?= Url::to(['/tarefa/index', 'id' => Yii::$app->user->id]) ?>" class="nav-item nav-link">Tarefas</a>



            <?php if (\Yii::$app->user->can('acederBackend')) { ?>
              <a href="<?= Yii::$app->params['backendBaseUrl'] . '/index.php?r=site/login' ?>" class="nav-item nav-link">Backend</a>
            <?php } ?>

        </div>
                <button class="btn nav-link" style="border:none;background:none;">
                    Logout (<?= Yii::$app->user->identity->username ?>)
                </button>

                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
</nav>

<main class="container py-4">
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
        $color = ($type == 'error' || $type == 'danger') ? '#a94442' : '#3c763d';
        $bgColor = ($type == 'error' || $type == 'danger') ? '#f2dede' : '#dff0d8';
        $border = ($type == 'error' || $type == 'danger') ? '#ebccd1' : '#d0e9c6';

        echo '<div style="padding: 15px; margin-bottom: 20px; border: 1px solid ' . $border . '; border-radius: 4px; color: ' . $color . '; background-color: ' . $bgColor . ';">';
        echo Html::encode($message);
        echo '</div>';
    }
    // Opcional: remover todos os flashes para garantir que não aparecem novamente
    Yii::$app->session->removeAllFlashes();
    ?>


    <?= $content ?>
</main>



<!-- JS Files -->
<script src="htmlcodex/js/main.js"></script>
<script src="htmlcodex/lib/wow/wow.min.js"></script>
<script src="htmlcodex/lib/easing/easing.min.js"></script>
<script src="htmlcodex/lib/waypoints/waypoints.min.js"></script>
<script src="htmlcodex/lib/owlcarousel/owl.carousel.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>