<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Dessert $model */

$this->registerJsFile(
   '@web/js/dessert.js',
   ['depends' => 'yii\web\JqueryAsset']
);

$this->title = 'Add Dessert';
$this->params['breadcrumbs'][] = ['label' => 'Desserts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
   ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
   }
</style>

<div class="row">
   <div class="col-12 col-md-6 col-xl-3 mx-auto">

      <div class="dessert-create">

         <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

         <div class="dessert-form">

            <?php $form = ActiveForm::begin([
               'action' => 'create',
               'method' => 'post',
            ]); ?>

            <div class="mb-3 field-dessert-quantity required">
               <label class="form-label" for="dessert-quantity">Quantity</label>
               <input type="number" min="1" step="1" class="form-control" name="Dessert[quantity]" value="1">
            </div>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->textInput() ?>

            <div class="mb-3 field-dessert-ingredients required">
               <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="form-label" for="dessert-ingredients">Ingredients</label>
                  <div id="add-ingredient" class="btn btn-icon btn-primary">
                     <i class="icon ti ti-plus"></i>
                  </div>
               </div>
               <ul id="ingredient-list">
               </ul>
            </div>

            <div class="form-group mt-5">
               <?= Html::submitButton('Save', ['class' => 'btn btn-teal w-100']) ?>
            </div>

            <?php ActiveForm::end(); ?>

         </div>

      </div>

   </div>
</div>