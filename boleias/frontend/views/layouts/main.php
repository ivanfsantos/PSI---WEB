<?php
/** @var \yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\helpers\Url;

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

    <!-- CSS Files -->
    <link rel="stylesheet" href="htmlcodex/css/bootstrap.min.css">
    <link rel="stylesheet" href="htmlcodex/css/style.css">

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

        </div>
                <button class="btn nav-link" style="border:none;background:none;">
                    Logout (<?= Yii::$app->user->identity->username ?>)
                </button>

                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->

<!-- MAIN CONTENT -->
<main class="container py-4">
    <?= $content ?>
</main>
<!-- END MAIN CONTENT -->

<!-- FOOTER -->
<footer class="bg-dark text-light text-center py-3 mt-5">
    <p class="mb-0">&copy; <?= date('Y') ?> Boleias - All Rights Reserved</p>
</footer>

<!-- JS Files -->
<script src="htmlcodex/js/main.js"></script>
<script src="htmlcodex/lib/wow/wow.min.js"></script>
<script src="htmlcodex/lib/easing/easing.min.js"></script>
<script src="htmlcodex/lib/waypoints/waypoints.min.js"></script>
<script src="htmlcodex/lib/owlcarousel/owl.carousel.min.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
