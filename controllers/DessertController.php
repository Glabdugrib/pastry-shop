<?php

namespace app\controllers;

use app\models\Dessert;
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
      $model = new Dessert();

      if ($this->request->isPost) {
         if ($model->load($this->request->post())) {
            $currentTime = time();
            $model->created_at = $currentTime;
            $model->updated_at = $currentTime;
            if ($model->save()) {
               return $this->redirect(['view', 'id' => $model->id]);
            }
         }
      }

      return $this->render('create', [
         'model' => $model,
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
