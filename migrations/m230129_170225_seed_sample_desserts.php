<?php

use yii\db\Migration;
use app\models\Dessert;
use app\models\Ingredient;

/**
 * Class m230129_170225_seed_sample_desserts
 */
class m230129_170225_seed_sample_desserts extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $dessertNum = rand(20, 30);
      $measureUnits = ['lb', 'g', 'oz', 'ml'];

      for($i = 0; $i < $dessertNum; $i++) {
         $time = strtotime('-'.rand(0, 100).' hours', time());
         $dessert = new Dessert();
         $dessert->name = 'Sample dessert #'. $i;
         $dessert->price = rand(1000, 10000) / 100;
         $dessert->status = Dessert::STATUS_ACTIVE;
         $dessert->created_at = $time;
         $dessert->updated_at = $time;
         $dessert->save();

         $ingredientNum = rand(0, 3);

         for($j = 0; $j < $ingredientNum; $j++) {
            $ingredient = new Ingredient();
            $ingredient->dessert_id = $dessert->id;
            $ingredient->name = 'Sample ingredient';
            $ingredient->quantity = rand(1, 10000) / 100;
            $ingredient->measure_unit = $measureUnits[array_rand($measureUnits)];
            $ingredient->created_at = $time;
            $ingredient->updated_at = $time;
            $ingredient->save();
         }
      }
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      return false;
   }
}
