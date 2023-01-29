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
    * Lists all Dessert models.
    *
    * @return string
    */
   public function actionIndex()
   {
      $dataProvider = new ActiveDataProvider([
         'query' => Dessert::find(),
         /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
      ]);

      return $this->render('index', [
         'dataProvider' => $dataProvider,
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
      return $this->render('view', [
         'model' => $this->findModel($id),
      ]);
   }

   /**
    * Creates a new Dessert model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return string|\yii\web\Response
    */
   public function actionCreate()
   {
      if ($this->request->isPost) {

         try {

            $quantity = intval( $this->request->bodyParams['Dessert']['quantity'] );
            if ($quantity <= 0) {
               $quantity = 1;
            }

            // creates num $quantity new desserts
            for ($i = 1; $i <= $quantity; $i++) {

               $dessert = new Dessert();

               if ($dessert->load($this->request->post())) {
                  $currentTime = time();

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
                        if ( !$ingredient->save() ) {
                           $dessert->delete();
                           throw new Exception('Ingredient creation failed');
                        }
                     }
                  }
                  else {
                     throw new Exception('Dessert creation failed');
                  }
               }
            }

            if ($quantity === 1) {
               Yii::$app->session->setFlash('success', 'Dessert has been created successfully.');
            } else {
               Yii::$app->session->setFlash('success', 'Desserts have been created successfully.');
            }
            
            return $this->redirect(['view', 'id' => $dessert->id]); 
         }
         catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Something went wrong. Please try again.');
         }
      }

      $dessert = new Dessert();

      return $this->render('create', [
         'model' => $dessert,
      ]);
   }

   /**
    * Updates an existing Dessert model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param int $id ID
    * @return string|\yii\web\Response
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionUpdate($id)
   {
      $model = $this->findModel($id);

      if ($this->request->isPost && $model->load($this->request->post())) {
         $currentTime = time();
         $model->updated_at = $currentTime;
         if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
         }
      }

      return $this->render('update', [
         'model' => $model,
      ]);
   }

   /**
    * Deletes an existing Dessert model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param int $id ID
    * @return \yii\web\Response
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionDelete($id)
   {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   /**
    * Finds the Dessert model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param int $id ID
    * @return Dessert the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = Dessert::findOne(['id' => $id])) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }
}
