<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property int $dessert_id
 * @property string $name
 * @property float $quantity
 * @property string $measure_unit
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Dessert $dessert
 */
class Ingredient extends \yii\db\ActiveRecord
{
   /**
    * {@inheritdoc}
    */
   public static function tableName()
   {
      return 'ingredient';
   }

   /**
    * {@inheritdoc}
    */
   public function rules()
   {
      return [
         [['dessert_id', 'name', 'quantity', 'measure_unit', 'created_at', 'updated_at'], 'required'],
         [['dessert_id', 'created_at', 'updated_at'], 'integer'],
         [['quantity'], 'number'],
         [['name'], 'string', 'max' => 255],
         [['measure_unit'], 'string', 'max' => 50],
         [['dessert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dessert::class, 'targetAttribute' => ['dessert_id' => 'id']],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'dessert_id' => 'Dessert ID',
         'name' => 'Name',
         'quantity' => 'Quantity',
         'measure_unit' => 'Measure Unit',
         'created_at' => 'Created At',
         'updated_at' => 'Updated At',
      ];
   }

   /**
    * Gets query for [[Dessert]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getDessert()
   {
      return $this->hasOne(Dessert::class, ['id' => 'dessert_id']);
   }
}
