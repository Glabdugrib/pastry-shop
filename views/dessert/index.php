<?php

use app\models\Dessert;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Dessert[] $desserts */
/** @var array $discountedPrices */
/** @var array $discounts */
/** @var bool $isGuest */

$this->title = 'Desserts';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="dessert-index">

   <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

   <?php if (!$isGuest) : ?>
      <p class="mb-4">
         <?= Html::a('<i class="icon ti ti-plus me-2"></i>Add dessert', ['create'], ['class' => 'btn btn-outline-primary']) ?>
      </p>
   <?php endif; ?>

   <?php if (count($desserts) > 0) : ?>
      <div class="row row-deck row-cards">
         <?php foreach ($desserts as $dessert) : ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3 p-2 position-relative">
               <a class="card shadow" href="<?= Url::to(['view', 'id' => $dessert->id]) ?>" style="color: currentColor; text-decoration: none;">
                  <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://img.itinari.com/page/content/original/d4d2f0bd-d597-481b-a384-05ccd9c585ee-istock-614978918-1.jpg?ch=DPR&dpr=2.625&w=994&s=2e620e4e260ddb41a565e51460a8387c)"></div>
                  <div class="card-header">
                     <h3 class="card-title"><?= $dessert->name ?></h3>
                  </div>
                  <div class="card-body">
                     <div class="datagrid fs-3" style="grid-template-columns: 1fr 1fr;">
                        <div class="datagrid-item text-center">
                           <div class="datagrid-title fw-bolder">Production date</div>
                           <div class="datagrid-content"><?= date('Y M d', $dessert->created_at) ?></div>
                        </div>
                        <?php if (!$discounts[$dessert->id] == 0) : ?>
                           <div class="datagrid-item text-center">
                              <div class="datagrid-title fw-bolder">Original price</div>
                              <div class="datagrid-content">
                                 <s><?= number_format($dessert->price, 2) ?>&euro;</s>
                              </div>
                           </div>
                           <div class="datagrid-item text-center">
                              <div class="datagrid-title fw-bolder">Discount</div>
                              <div class="datagrid-content"><?= $discounts[$dessert->id] * 100 ?>%</div>
                           </div>
                        <?php endif; ?>
                        <div class="datagrid-item text-center">
                           <div class="datagrid-title fw-bolder">Price</div>
                           <div class="datagrid-content">
                              <span class="badge badge-outline text-teal">
                                 <?= number_format($discountedPrices[$dessert->id], 2) ?>&euro;
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <?php if (!$isGuest) : ?>
               <a href="<?= Url::to(['update', 'id' => $dessert->id]) ?>" class="btn btn-icon btn-yellow shadow position-absolute" style="top: 1.5rem; right: 1.5rem">
                  <i class="icon ti ti-pencil"></i>
               </a>
               <a href="<?= Url::to(['delete', 'id' => $dessert->id]) ?>" class="btn btn-icon btn-red shadow position-absolute" style="top: 5rem; right: 1.5rem" data-confirm="Are you sure you want to delete this item?" data-method="post">
                  <i class="icon ti ti-trash"></i>
               </a>
               <?php endif; ?>
            </div>
         <?php endforeach; ?>
      </div>
   <?php else : ?>
      <div class="page page-center">
         <div class="container-tight py-4">
            <div class="empty">
               <i class="ti ti-cake-off mb-3" style="font-size: 150px;"></i>
               <p class="empty-title">Oops… It looks like that someone ate all the cakes!</p>
            </div>
         </div>
      </div>
   <?php endif; ?>

</div>