<?php

use yii\db\Migration;

/**
 * Class m230128_165704_seed_user
 */
class m230128_165704_seed_user extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $currentTime = time();

      $this->insert('{{%user}}', [
         'username' => 'luana',
         'auth_key' => Yii::$app->security->generateRandomString(),
         'password_hash' => Yii::$app->security->generatePasswordHash('password1234'),
         'password_reset_token' => Yii::$app->security->generateRandomString(),
         'email' => 'luana@email.it',
         'created_at' => $currentTime,
         'updated_at' => $currentTime,
      ]);

      $this->insert('{{%user}}', [
         'username' => 'maria',
         'auth_key' => Yii::$app->security->generateRandomString(),
         'password_hash' => Yii::$app->security->generatePasswordHash('password5678'),
         'password_reset_token' => Yii::$app->security->generateRandomString(),
         'email' => 'maria@email.it',
         'created_at' => $currentTime,
         'updated_at' => $currentTime,
      ]);
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      echo "m230128_165704_seed_user cannot be reverted.\n";

      return false;
   }
}
