<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dessert}}`.
 */
class m230128_172954_create_dessert_table extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable('{{%dessert}}', [
         'id' => $this->primaryKey(),
         'name' => $this->string(255)->notNull(),
         'price' => $this->float()->notNull(),
         'created_at' => $this->integer()->notNull(),
         'updated_at' => $this->integer()->notNull(),
      ]);
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropTable('{{%dessert}}');
   }
}
