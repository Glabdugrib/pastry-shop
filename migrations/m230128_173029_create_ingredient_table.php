<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%create_ingredient}}`.
 */
class m230128_173029_create_ingredient_table extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable('{{%ingredient}}', [
         'id' => $this->primaryKey(),
         'dessert_id' => $this->integer()->notNull(),
         'name' => $this->string(255)->notNull(),
         'quantity' => $this->float()->notNull(),
         'measure_unit' => $this->string(50)->notNull(),
         'created_at' => $this->integer()->notNull(),
         'updated_at' => $this->integer()->notNull(),
      ]);

      // creates index for column `dessert_id`
      $this->createIndex(
         'idx-ingredient-dessert_id',
         'ingredient',
         'dessert_id'
      );

      // add foreign key for table `dessert`
      $this->addForeignKey(
         'fk-ingredient-dessert_id',
         'ingredient',
         'dessert_id',
         'dessert',
         'id',
         'CASCADE'
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      // drops foreign key for table `dessert`
      $this->dropForeignKey(
         'fk-ingredient-dessert_id',
         'ingredient'
      );

      // drops index for column `dessert_id`
      $this->dropIndex(
         'idx-ingredient-dessert_id',
         'ingredient'
      );

      $this->dropTable('{{%ingredient}}');
   }
}
