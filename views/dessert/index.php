<?php

use app\models\Dessert;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Dessert[] $desserts */
/** @var bool $isGuest */

$this->title = 'Desserts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dessert-index">

   <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

   <?php if (!$isGuest) : ?>
      <p class="mb-4">
         <?= Html::a('Add dessert', ['create'], ['class' => 'btn btn-primary']) ?>
      </p>
   <?php endif; ?>

   <?php if (count($desserts) > 0) : ?>
      <div class="row row-card g-4">
         <?php foreach ($desserts as $dessert) : ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
               <a href="<?= Url::to(['view', 'id' => $dessert->id]) ?>" style="color: currentColor; text-decoration: none;">
                  <div class="card shadow">
                     <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://imagesvc.meredithcorp.io/v3/mm/image?url=https%3A%2F%2Fimg1.cookinglight.timeinc.net%2Fsites%2Fdefault%2Ffiles%2Fstyles%2F4_3_horizontal_-_1200x900%2Fpublic%2F1542062283%2Fchocolate-and-cream-layer-cake-1812-cover.jpg%3Fitok%3DR_xDiShk)"></div>
                     <div class="card-body">
                        <h3 class="card-title"><?= $dessert->name ?></h3>
                     </div>
                     <div class="card-footer">
                        <div class="datagrid" style="grid-template-columns: 1fr 1fr;">
                           <div class="datagrid-item text-center">
                              <div class="datagrid-title fw-bolder">Production date</div>
                              <div class="datagrid-content"><?= date('Y M d', $dessert->created_at) ?></div>
                           </div>
                           <div class="datagrid-item text-center">
                              <div class="datagrid-title fw-bolder">Original price</div>
                              <div class="datagrid-content">
                                 <s><?= number_format($dessert->price, 2) ?>&euro;</s>
                              </div>
                           </div>
                           <div class="datagrid-item text-center">
                              <div class="datagrid-title fw-bolder">Discount</div>
                              <div class="datagrid-content">0%</div>
                           </div>
                           <div class="datagrid-item text-center">
                              <div class="datagrid-title fw-bolder">Price</div>
                              <div class="datagrid-content">
                                 <span class="badge badge-outline text-teal">
                                    <?= number_format($dessert->price, 2) ?>&euro;
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
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