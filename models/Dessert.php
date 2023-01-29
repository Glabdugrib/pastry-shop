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
}
