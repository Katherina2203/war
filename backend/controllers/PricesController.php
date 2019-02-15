<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Accounts;
use common\models\Prices;
use backend\models\PricesSearch;
use \common\models\Requests;
use backend\models\RequestsSearch;
use \common\models\Elements;
use common\models\Paymentinvoice;


/**
 * PricesController implements the CRUD actions for Prices model.
 */
class PricesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Prices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PricesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchRequest = new RequestsSearch();
        $modelacc = new Accounts();
        //вывести кнопку добавить позицию в счет , добавить счет
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelacc' => $modelacc,
            'searchRequest' => $searchRequest,
        ]);
    }
    
    public function actionViewprice($idel)
    {
        $searchModel = new PricesSearch();
        
        $query = Prices::find()->where(['idel' => $idel])->orderBy('created_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
        $searchRequest = new RequestsSearch();
        $modelacc = new Accounts();
        //вывести кнопку добавить позицию в счет , добавить счет
        return $this->render('viewprice', [
            'model' => $this->findModel($idel),
            'modelacc' => $modelacc,
            'searchRequest' => $searchRequest,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Prices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prices();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewprice', 'idel' => $model->idpr]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAddprice($idel)
    {
        $model = new Prices();
        $model->idel = $idel;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // Yii::$app->session->setFlash('success', 'Цена успешно добавлена!');
            return $this->redirect(['viewprice', 'idel' => $model->idel]);
        } else {
            return $this->render('addprice', [
                'model' => $model,
            ]);
        }
    }
    
     public function actionCreateitem($idelement)
    {
        $model = new Prices();
        $model->idel = $idelement;
        $modelpur = new \common\models\Purchaseorder();
        $model->idcurrency = '1';
        $model->forUP = '1';
        $model->pdv = '20%';
        $model->usd = '27.2';

        if ($model->load(Yii::$app->request->post())) {
            $modelpur->idelement = $model->idel;
            $model->save();
            return $this->redirect(['view', 'id' => $model->idpr]);
        } else {
            return $this->render('createitem', [
                'model' => $model,
                'modelpur' => $modelpur,
            ]);
        }
    }

    /**
     * Updates an existing Prices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpr]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionChangeprice($idpr)
    {
        $modelpay = new Paymentinvoice();
        $modelacc = new Accounts();
        $model = $this::findModel($idpr);

      //  $model->idel = $idel;
        
         if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['paymentinvoice/itemsin', 'idinvoice' => $modelacc->idinvoice]); 
        } else {
            return $this->render('changeprice', [
                'model' => $model,
                'modelpay' => $modelpay,
                'modelacc' => $modelacc
            ]);
        }
    }

    /**
     * Deletes an existing Prices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
