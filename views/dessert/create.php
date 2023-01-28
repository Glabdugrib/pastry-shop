<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Dessert $model */

$this->title = 'Create Dessert';
$this->params['breadcrumbs'][] = ['label' => 'Desserts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dessert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
