<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$menuItemsLeft = [
   ['label' => 'Desserts', 'url' => ['/dessert/index']]
];
 
if (Yii::$app->user->isGuest) {
   $menuItemsRight[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
   $menuItemsLeft[] = ['label' => 'Add dessert', 'url' => ['/dessert/create']];
   $menuItemsRight[] = '<li class="nav-item">' . Html::beginForm(['/site/logout']) . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'nav-link btn-link logout']) . Html::endForm() . '</li>';
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
   <title><?= Html::encode($this->title) ?></title>
   <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
   <?php $this->beginBody() ?>

   <header id="header">
      <?php
      NavBar::begin([
         'brandLabel' => '<i class="ti ti-cake me-2 fs-1"></i><span class="fs-3 me-3">Pastry Shop</span>',
         'brandUrl' => ['//dessert/index'],
         'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark']
      ]);
      echo Nav::widget([
         'options' => ['class' => 'navbar-nav ms-2 me-auto fs-3'],
         'items' => $menuItemsLeft
      ]);
      echo Nav::widget([
         'options' => ['class' => 'navbar-nav ms-2 fs-3'],
         'items' => $menuItemsRight
      ]);
      NavBar::end();
      ?>
   </header>

   <main id="main" class="flex-shrink-0" role="main">
      <div class="container py-3 px-3 px-md-2">
         <?php if (!empty($this->params['breadcrumbs'])) : ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
         <?php endif ?>
         <?= Alert::widget() ?>
         <div class="content pt-3"><?= $content ?></div>
      </div>
   </main>

   <footer id="footer" class="mt-auto py-3 bg-light">
      <div class="container">
         <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Simone Sada 2023 Jan 29</div>
            <div class="col-md-6 text-center text-md-end"><?= 'Powered with Yii2, jQuery, Bootstrap 5 and Tabler' ?></div>
         </div>
      </div>
   </footer>

   <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>