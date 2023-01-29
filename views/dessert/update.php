<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Dessert $model */

$this->registerJsFile(
   '@web/js/dessert.js',
   ['depends' => 'yii\web\JqueryAsset']
);

$this->title = 'Update Dessert: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Desserts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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

      <div class="dessert-update">

         <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

         <div class="dessert-form">

            <?php $form = ActiveForm::begin([
               'action' => ['update', 'id' => $model->id],
               'method' => 'post',
            ]); ?>

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
                  <?php foreach ($model->ingredients as $ingredient) : ?>
                  <li class="ingredient-item mb-4">
                     <div class="row">
                        <div class="col d-flex flex-column gap-2">
                           <input type="text" class="form-control" name="Dessert[ingredients][<?= $ingredient->id ?>][name]" placeholder="Insert ingredient name" value="<?= $ingredient->name ?>">
                           <input type="number" class="form-control" name="Dessert[ingredients][<?= $ingredient->id ?>][quantity]" placeholder="Insert quantity" min="0.001" step="0.001" value="<?= $ingredient->quantity ?>">
                           <input type="text" class="form-control" name="Dessert[ingredients][<?= $ingredient->id ?>][measure_unit]" placeholder="Insert measure unit" value="<?= $ingredient->measure_unit ?>">
                        </div>
                        <div class="col-auto d-flex align-items-center">
                           <button class="delete-ingredient btn btn-icon btn-outline-danger">
                              <i class="ti ti-trash"></i>
                           </button>
                        </div>
                     </div>
                  </li>
                  <?php endforeach; ?>

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