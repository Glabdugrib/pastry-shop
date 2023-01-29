<?php

namespace app\controllers;

use app\models\Dessert;
use app\models\Ingredient;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DessertController implements the CRUD actions for Dessert model.
 */
class DessertController extends Controller
{
   /**
    * @inheritDoc
    */
   public function behaviors()
   {
      return array_merge(
         parent::behaviors(),
         [
            'access' => [
               'class' => AccessControl::class,
               'rules' => [
                  [
                     'actions' => ['index', 'view'],
                     'allow' => true,
                  ],
                  [
                     'actions' => ['create', 'update', 'delete'],
                     'allow' => true,
                     'roles' => ['@'],
                  ],
               ],
            ],
            'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                  'delete' => ['POST'],
               ],
            ],
         ]
      );
   }

   /**
    * Lists all active Dessert models ordered by creation date.
    *
    * @return string
    */
   public function actionIndex()
   {
      $desserts = Dessert::find()->where(['status' => Dessert::STATUS_ACTIVE])->orderBy(['created_at' => SORT_ASC])->with('ingredients')->all();
      $validDesserts = [];
      $discountedPrices = [];
      $discounts = [];

      // checks if every dessert model is still valid or not, if yes it prepares data array for the view.
      foreach ($desserts as $dessert) {
         $discountedData = $dessert->getDiscountedData();
         // if not expired
         if (isset($discountedData)) {
            $validDesserts[$dessert->id] = $dessert;
            $discountedPrices[$dessert->id] = $discountedData['price'];
            $discounts[$dessert->id] = $discountedData['discount'];
         }
      }

      return $this->render('index', [
         'desserts' => $validDesserts,
         'discountedPrices' => $discountedPrices,
         'discounts' => $discounts,
         'isGuest' => Yii::$app->user->isGuest
      ]);
   }

   /**
    * Displays a single Dessert model.
    * @param int $id ID
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionView($id)
   {
      $dessert = $this->findModel($id);
      $discountedData = $dessert->getDiscountedData();

      // if not expired
      if (isset($discountedData)) {
         return $this->render('view', [
            'dessert' => $dessert,
            'discountedPrice' => $discountedData['price'],
            'discount' => $discountedData['discount'],
            'isGuest' => Yii::$app->user->isGuest
         ]);
      }

      Yii::$app->session->setFlash('error', 'The dessert is expired.');
      $this->redirect(['index']);
   }

   /**
    * Creates a new Dessert model and related Ingredient models.
    * If creation is successful, the browser will be redirected to the 'view' page (or to 'index' in case of multiple models created).
    * @return string|\yii\web\Response
    */
   public function actionCreate()
   {
      if ($this->request->isPost) {

         try {

            $quantity = intval($this->request->bodyParams['Dessert']['quantity']);
            if ($quantity <= 0) {
               $quantity = 1;
            }

            // creates num $quantity new desserts
            for ($i = 1; $i <= $quantity; $i++) {

               $dessert = new Dessert();

               if ($dessert->load($this->request->post())) {
                  $currentTime = time();

                  $dessert->status = Dessert::STATUS_ACTIVE;
                  $dessert->created_at = $currentTime;
                  $dessert->updated_at = $currentTime;

                  $ingredientsParams = $this->request->bodyParams['Dessert']['ingredients'] ?? [];

                  if ($dessert->save()) {

                     // ingredient models creation
                     foreach ($ingredientsParams as $ingredientParams) {
                        $ingredient = new Ingredient();
                        $ingredient->dessert_id = $dessert->id;
                        $ingredient->name = $ingredientParams['name'];
                        $ingredient->quantity = $ingredientParams['quantity'];
                        $ingredient->measure_unit = $ingredientParams['measure_unit'];
                        $ingredient->created_at = $currentTime;
                        $ingredient->updated_at = $currentTime;
                        if (!$ingredient->save()) {
                           // if creation fail => delets Dessert model and all related Ingredients
                           $dessert->delete();
                           throw new Exception('Ingredient creation failed');
                        }
                     }
                  } else {
                     throw new Exception('Dessert creation failed');
                  }
               }
            }

            if ($quantity === 1) {
               Yii::$app->session->setFlash('success', 'Dessert has been created successfully.');
               return $this->redirect(['view', 'id' => $dessert->id]);
            } else {
               Yii::$app->session->setFlash('success', 'Desserts have been created successfully.');
               return $this->redirect(['index']);
            }
         } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Something went wrong. Please try again.');
         }
      }

      $dessert = new Dessert();

      return $this->render('create', [
         'model' => $dessert,
      ]);
   }

   /**
    * Updates an existing Dessert model and related Ingredient models.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param int $id ID
    * @return string|\yii\web\Response
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionUpdate($id)
   {
      $dessert = $this->findModel($id);

      $discountedData = $dessert->getDiscountedData();

      if (isset($discountedData)) {

         if ($this->request->isPost) {
            try {
               if ($dessert->load($this->request->post())) {

                  $currentTime = time();
                  $dessert->updated_at = $currentTime;

                  $ingredientsParams = $this->request->bodyParams['Dessert']['ingredients'] ?? [];
                  $ingredientIds = array_keys($ingredientsParams);

                  if ($dessert->save()) {

                     // deletes removed ingredients
                     foreach ($dessert->ingredients as $ingredient) {
                        if (!in_array($ingredient->id, $ingredientIds)) {
                           $ingredient->delete();
                        }
                     }

                     // updates existing ingredients and create new ones
                     foreach ($ingredientsParams as $ingredientId => $ingredientParams) {

                        // The request can get 2 type of keys: int or string (ex. $id or "N-$id").
                        // The first one for already existing ingredients, the latter for the new ones.
                        if (is_integer($ingredientId)) {
                           $ingredient = Ingredient::findOne($ingredientId);
                        } else {
                           $ingredient = new Ingredient();
                        }
                        $ingredient->dessert_id = $dessert->id;
                        $ingredient->name = $ingredientParams['name'];
                        $ingredient->quantity = $ingredientParams['quantity'];
                        $ingredient->measure_unit = $ingredientParams['measure_unit'];
                        $ingredient->created_at = $currentTime;
                        $ingredient->updated_at = $currentTime;
                        if (!$ingredient->save()) {
                           throw new Exception('Ingredients update failed');
                        }
                     }

                     Yii::$app->session->setFlash('success', 'Dessert has been updated successfully.');
                     return $this->redirect(['view', 'id' => $dessert->id]);
                  } else {
                     throw new Exception('Dessert update failed');
                  }
               }
            } catch (Exception $ex) {
               Yii::$app->session->setFlash('error', 'Something went wrong. Please try again.');
               return $this->redirect(['view', 'id' => $dessert->id]);
            }
         }

         return $this->render('update', [
            'model' => $dessert,
         ]);
      }

      Yii::$app->session->setFlash('error', 'The dessert is expired.');
      $this->redirect(['index']);
   }

   /**
    * Set the status of an existing Dessert model to "expired".
    * The browser will be redirected to the 'index' page.
    * @param int $id ID
    * @return \yii\web\Response
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionDelete($id)
   {
      try {
         $dessert = $this->findModel($id);
         $dessert->status = Dessert::STATUS_EXPIRED;

         if (!$dessert->save()) {
            throw new Exception('Dessert delete failed');
         }

         Yii::$app->session->setFlash('success', 'Dessert has been deleted successfully.');
      }
      catch (Exception $ex) {
         Yii::$app->session->setFlash('error', 'Something went wrong. Please try again.');
      }

      return $this->redirect(['index']);
   }

   /**
    * Finds the active Dessert model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param int $id ID
    * @return Dessert the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      $model = Dessert::find()->where(['id' => $id, 'status' => Dessert::STATUS_ACTIVE])->with('ingredients')->one();

      if (isset($model)) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }
}
