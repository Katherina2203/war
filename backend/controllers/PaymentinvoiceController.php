<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;


use common\models\Accounts;
use backend\models\AccountsSearch;
use common\models\Paymentinvoice;
use backend\models\PaymentinvoiceSearch;
use common\models\Prices;
use backend\models\RequestsByIdSearch;
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
            'access' => [
                'class' => AccessControl::className(),
              //  'only' => ['create', 'update'],
                'rules' => [
                    [
                       // 'actions' => ['adminka'],
                        'allow' => true,
                      //  'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
                    ],
                ],
            ],
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
        $searchModelacc = new AccountsSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    /*    $query = Paymentinvoice::find()->orderBy('created_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/
     //   if (Yii::$app->request->post('hasEditable')) {
            
     //   }

        return $this->render('index', [
            'model' =>$model,
            'modelacc' =>$modelacc,
            'searchModel' => $searchModel,
            'searchModelacc' => $searchModelacc,
            'dataProvider' => $dataProvider,
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

    public function actionItemsin($idinvoice)
    {
        $modelpay = Paymentinvoice::findOne($idinvoice);
        if(is_null($modelpay)) {
            return Yii::$app->getResponse()->redirect(['paymentinvoice/index']);
        }
       
        $modelRequestsByIdSearch = new RequestsByIdSearch();
        $modelRequestsByIdSearch->idinvoice = $idinvoice;
        $modelRequestsByIdSearch->search();
       

        $model = new Accounts();
        $searchModel = new AccountsSearch();
        $model->idinvoice = $idinvoice;
        
        $query = Accounts::find()->where(['idinvoice' => $idinvoice])->joinWith(['elements', 'prices', 'accountsRequests'])->orderBy('sorting ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 80,
            ],
        ]);
        
        
        return $this->render('itemsin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
            'model' =>$model,
            'modelpay' => $modelpay,
            'modelRequestsByIdSearch' => $modelRequestsByIdSearch,
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
        $model->date_invoice = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           // $model->confirm = '0';
            $model->save(false);
            return $this->redirect(['itemsin', 'idinvoice' => $model->idpaymenti]); //view
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionAddfast()
    {
        $model = new Paymentinvoice();
        
        return $this->render('addfast', [
                'model' => $model,
            ]);
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

    //    if (isset($_POST['hasEditable'])) {
       //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            
        if ($model->load(Yii::$app->request->post())) {
         //   if($model->confirm = Paymentinvoice::CONFIRM_CANCEL){
                 $transaction = $model->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(  //$return->getDb()->beginTransaction
                 //   Transaction::SERIALIZABLE
                    );
            try{
                $valid = $model->validate();
             //   Yii::$app->db->createCommand()->update('accounts', ['status' => Accounts::ACCOUNTS_CANCEL],['idinvoice' => $model->idpaymenti])->execute();
                
                if ($valid) {
                // the model was validated, no need to validate it once more
                    $model->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Статус данного счета успешно изменен!');
                  //  return $this->redirect(['view', 'id' => $model->idpaymenti]);
                    return $this->redirect(['itemsin', 'idinvoice' => $model->idpaymenti]);
                } else {
                    $transaction->rollBack();
                } 
                 
            }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
       //     }
           
            
           
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
       // }
        }
    }
    
    public function actionUpdateconfirm($id)
    {
        $model= $this->findModel($id);
        
        if($model->load(\yii::$app->request->post()) && $model->save()){   
         //   $model->confirm = '1';
            Yii::$app->session->setFlash('success', 'Статус данного счета успешно изменен!');
            return $this->redirect(['itemsin', 'id' => $model->id]);
          
        }
        return $this->render('updateconfirm', [
            'model' => $model,
           
        ]);
    }
    
    public function actionEditinvoice($id)
    {
        $model = $this->findModel($id);

    //    if (isset($_POST['hasEditable'])) {
       //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            
        if ($model->load(Yii::$app->request->post())) {
            if($model->confirm = Paymentinvoice::CONFIRM_CANCEL){
                 $transaction = $model->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(  //$return->getDb()->beginTransaction
                 //   Transaction::SERIALIZABLE
                    );
            try{
                $valid = $model->validate();
                Yii::$app->db->createCommand()->update('accounts', ['status' => Accounts::ACCOUNTS_CANCEL],['idinvoice' => $model->idpaymenti])->execute();
                
                if ($valid) {
                // the model was validated, no need to validate it once more
                    $model->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Статус данного счета успешно изменен!');
                    return $this->redirect(['view', 'id' => $model->idpaymenti]);
                } else {
                    $transaction->rollBack();
                } 
                 
            }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
            }
           
            
           
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
       // }
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
