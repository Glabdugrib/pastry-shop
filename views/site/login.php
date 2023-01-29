<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
   <div class="col-12 col-md-6 col-xl-3 mx-auto">

      <div class="site-login">
         <h1><?= Html::encode($this->title) ?></h1>

         <p>Please fill out the following fields to login:</p>

         <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
               'template' => "{label}\n{input}\n{error}",
               'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
               'inputOptions' => ['class' => 'col-lg-3 form-control'],
               'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
         ]); ?>

         <?= $form->field($model, 'email')->input('email') ?>

         <?= $form->field($model, 'password')->passwordInput() ?>

         <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col custom-control custom-checkbox d-flex\">{input} {label}</div>\n<div class=\"col\">{error}</div>",
         ]) ?>

         <div class="form-group">
            <div class="col">
               <?= Html::submitButton('Login', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
            </div>
         </div>

         <?php ActiveForm::end(); ?>

         <div class="mt-3" style="color:#999;">
            You may login with:
            <ul>
               <li><strong>luana@email.it/password1234</strong></li>
               <li><strong>maria@email.it/password5678</strong></li>
            </ul>
         </div>
      </div>

   </div>
</div>