<?php

namespace frontend\modules\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\data\ActiveDataProvider;

use common\models\Paymentinvoice;
use backend\models\PaymentinvoiceSearch;
use common\models\Accounts;
use backend\models\AccountsSearch;
/**
 * PaymentinvoiceController implements the CRUD actions for Paymentinvoice model.
 */
class PaymentinvoiceController extends Controller
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
     * Lists all Paymentinvoice models.
     * @return mixed
     */

        public function actionIndex()
    {
       
        $model = new Paymentinvoice();
        $modelacc = new Accounts();
        
       
        
        $searchModel = new PaymentinvoiceSearch();
      //  $searchModelacc = new AccountsSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'model' =>$model,
            'modelacc' =>$modelacc,
            'searchModel' => $searchModel,
           // 'searchModelacc' => $searchModelacc,
            'dataProvider' => $dataProvider,
          //  'dataProvideracc' => $dataProvideracc,
        ]);
    }



    /**
     * Displays a single Paymentinvoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModelacc = new AccountsSearch();
        $query = Accounts::find()->where(['idinvoice' => $id])->joinWith(['elements', 'prices']);
        $dataProvideracc = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 80,
            ],
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModelacc' => $searchModelacc,
            'dataProvideracc' => $dataProvideracc,
        ]);
    }
    
    /**
     * Displays a Paymentinvoice model and items in the invoice.
     * @param integer $id
     * @return mixed
     */
     public function actionItemsin($id)
    {
        $model = new Accounts();
        $searchModel = new AccountsSearch();
        
        $query = Accounts::find()->where(['idinvoice' => $id])->joinWith(['elements', 'prices']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 80,
            ],
        ]);
        
        $modelpay = Paymentinvoice::findOne($id);
        
        return $this->render('itemsin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' =>$model,
            'modelpay' => $modelpay
        ]);
    }

    /**
     * Creates a new Paymentinvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paymentinvoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpaymenti]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAdditems($idinv)
    {
        $modelPayment = new Paymentinvoice();
        $modelsAccounts = new Accounts();
        $modelsAccounts->idinvoice = $idinv;
        $modelsAccounts->status = 2;
        
        $searchModelAccounts = new AccountsSearch();
        $query = Accounts::find()->where(['idinvoice' => $idinv]);
        $dataProviderAccounts = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if ($modelsAccounts->load(Yii::$app->request->post()) && $modelsAccounts->save()) {
          
        
        return $this->render('viewitem', [
             'id' => $modelsAccounts->idord,
             'modelPayment' => $this->findModel($idinv),
             'dataProviderAccounts' => $dataProviderAccounts,
            // 'model' => $this->findModel($id),
           // 'modelsAccounts' => $modelsAccounts,
        ]);
        
        } else {
            return $this->render('additems', [
                'modelPayment' => $this->findModel($idinv),
                'modelsAccounts' => $modelsAccounts,
            ]);
        }
    }
    
   

    /**
     * Updates an existing Paymentinvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpaymenti]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Paymentinvoice model.
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
     * Finds the Paymentinvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paymentinvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paymentinvoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
