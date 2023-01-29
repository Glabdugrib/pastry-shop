<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dessert".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Ingredient[] $ingredients
 */
class Dessert extends \yii\db\ActiveRecord
{
   const STATUS_ACTIVE = 1;
   const STATUS_EXPIRED = 2;

   const DISCOUNTS_BY_HOURS = [
      24 => 0,
      48 => 0.2,
      72 => 0.8,
   ];

   /**
    * {@inheritdoc}
    */
   public static function tableName()
   {
      return 'dessert';
   }

   /**
    * {@inheritdoc}
    */
   public function rules()
   {
      return [
         [['name', 'price', 'status', 'created_at', 'updated_at'], 'required'],
         [['price'], 'number'],
         [['status', 'created_at', 'updated_at'], 'integer'],
         [['name'], 'string', 'max' => 255],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'name' => 'Name',
         'price' => 'Price',
         'created_at' => 'Created At',
         'updated_at' => 'Updated At',
      ];
   }

   /**
    * Gets query for [[Ingredients]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getIngredients()
   {
      return $this->hasMany(Ingredient::class, ['dessert_id' => 'id']);
   }

   /**
    * Gets the discounted price and discount based on how many hours passed from the dessert creation date.
    */
   public function getDiscountedData()
   {
      $shelfLife = $this->getShelfLife(); // in hours
      $isExpired = $this->isExpired($shelfLife);

      if ($isExpired) {
         return null;
      }

      foreach (self::DISCOUNTS_BY_HOURS as $hours => $discount) {
         if ($shelfLife <= $hours) {
            return [
               'discount' => $discount,
               'price' => $this->price * (1 - $discount)
            ];
         }
      }
   }

   /**
    * Gets the shelf life of the dessert in hours (rounded to floor).
    */
   public function getShelfLife()
   {
      return floor((time() - $this->created_at) / 60 / 60);
   }

   /**
    * Check if the Dessert models is expired or not.
    * In case it is expired, sets the Dessert  status to "expired".
    * @param int $shelfLife in hours
    * @return bool
    */
   public function isExpired($shelfLife)
   {
      $maxShelfLife = max( array_keys(self::DISCOUNTS_BY_HOURS) );

      if ($shelfLife <= $maxShelfLife) {
         return false;
      } else {
         $this->status = self::STATUS_EXPIRED;
         $this->save();
         return true;
      }
   }
}
