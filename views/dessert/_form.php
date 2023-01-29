<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\Dessert $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $action */

$this->registerJsFile(
   '@web/js/dessert.js',
   ['depends' => 'yii\web\JqueryAsset']
);
?>

<div class="dessert-form">

   <?php $form = ActiveForm::begin([
      'id' => 'form-dessert',
      'action' => [Yii::$app->controller->action->id],
      'method' => 'post',
   ]); ?>

   <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'price')->textInput() ?>

   <div id="add-ingredient" class="btn btn-primary">Add ingredient</div>

   <ul id="ingredient-list" class="">
   </ul>

   <div class="form-group">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>