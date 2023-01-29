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
               <?= Html::a('Update', ['update', 'id' => $dessert->id], ['class' => 'btn btn-primary']) ?>
               <?= Html::a('Delete', ['delete', 'id' => $dessert->id], [
                  'class' => 'btn btn-danger',
                  'data' => [
                     'confirm' => 'Are you sure you want to delete this item?',
                     'method' => 'post',
                  ],
               ]) ?>
            </p>
         <?php endif; ?>

         <div class="dessert-form">

            <div class="card shadow">
               <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://imagesvc.meredithcorp.io/v3/mm/image?url=https%3A%2F%2Fimg1.cookinglight.timeinc.net%2Fsites%2Fdefault%2Ffiles%2Fstyles%2F4_3_horizontal_-_1200x900%2Fpublic%2F1542062283%2Fchocolate-and-cream-layer-cake-1812-cover.jpg%3Fitok%3DR_xDiShk)"></div>
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