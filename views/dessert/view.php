<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Dessert $dessert */
/** @var float $discount */
/** @var float $discountedPrice */
/** @var bool $isGuest */

$this->title = $dessert->name;
$this->params['breadcrumbs'][] = ['label' => 'Desserts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="row">
   <div class="col-12 col-md-6 col-xl-4 mx-auto">

      <div class="dessert-view">

         <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

         <?php if (!$isGuest) : ?>
            <p class="mb-4">
               <?= Html::a('<i class="icon ti ti-pencil me-2"></i>Update', ['update', 'id' => $dessert->id], ['class' => 'btn btn-outline-yellow']) ?>
               <?= Html::a('<i class="icon ti ti-trash me-2"></i>Delete', ['delete', 'id' => $dessert->id], [
                  'class' => 'btn btn-outline-danger',
                  'data' => [
                     'confirm' => 'Are you sure you want to delete this item?',
                     'method' => 'post',
                  ],
               ]) ?>
            </p>
         <?php endif; ?>

         <div class="dessert-form">

            <div class="card shadow">
               <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://img.itinari.com/page/content/original/d4d2f0bd-d597-481b-a384-05ccd9c585ee-istock-614978918-1.jpg?ch=DPR&dpr=2.625&w=994&s=2e620e4e260ddb41a565e51460a8387c)"></div>
               <div class="card-header">
                  <h3 class="card-title"><?= $dessert->name ?></h3>
               </div>
               <div class="card-body">

                  <div class="datagrid mb-4" style="grid-template-columns:  1fr 1fr;">
                     <div class="datagrid-item">
                        <div class="datagrid-title fw-bolder">Production date</div>
                        <div class="datagrid-content"><?= date('Y M d', $dessert->created_at) ?></div>
                     </div>
                     <?php if (!$isGuest) : ?>
                        <div class="datagrid-item">
                           <div class="datagrid-title fw-bolder">Last update</div>
                           <div class="datagrid-content"><?= date('Y M d', $dessert->updated_at) ?></div>
                        </div>
                     <?php endif; ?>
                     <?php if (!$discount == 0) : ?>
                     <div class="datagrid-item">
                        <div class="datagrid-title fw-bolder">Original price</div>
                        <div class="datagrid-content">
                           <s><?= number_format($dessert->price, 2) ?>&euro;</s>
                        </div>
                     </div>
                     <div class="datagrid-item">
                        <div class="datagrid-title fw-bolder">Discount</div>
                        <div class="datagrid-content"><?= $discount * 100 ?>%</div>
                     </div>
                     <?php endif; ?>
                     <div class="datagrid-item">
                        <div class="datagrid-title fw-bolder">Price</div>
                        <div class="datagrid-content">
                           <span class="badge badge-outline text-teal">
                              <?= number_format($discountedPrice, 2) ?>&euro;
                           </span>
                        </div>
                     </div>
                  </div>
                  <div class="datagrid">
                     <div class="datagrid-item">
                        <div class="datagrid-title fw-bolder">Ingredients</div>
                        <?php if (count($dessert->ingredients) > 0) : ?>
                           <div class="datagrid-content ps-2">
                              <ul>
                                 <?php foreach ($dessert->ingredients as $ingredient) : ?>
                                    <li class="mt-1"><?= $ingredient->name ?>: <?= $ingredient->quantity ?> <?= $ingredient->measure_unit ?></li>
                                 <?php endforeach; ?>
                              </ul>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
            </div>

         </div>

      </div>

   </div>
</div>