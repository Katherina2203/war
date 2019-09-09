<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\helpers\Json;
use yii\base\Model;
use yii\base\ErrorException;

use common\models\Accounts;
use common\models\Receipt;
use common\models\Elements;
use common\models\Prices;
use common\models\Purchaseorder;
use common\models\Paymentinvoice;
use common\models\Requests;
use common\models\AccountsRequests;
use backend\models\AccountsSearch;
use backend\models\ReceiptSearch;
use backend\models\ElementsSearch;
use backend\models\RequestsByIdSearch;
use backend\components\Amounts;


/**
 * AccountsController implements the CRUD actions for Accounts model.
 */
class AccountsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
            //    'only' => ['index', 'view','create'],
                'rules' => [
                    [
                      //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['Purchasegroup'],
                        'actions' => ['atttoinvoice', 'createitem', 'createreceipt'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view', 'viewin', 'viewreceipt'],
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
     * Lists all Accounts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Accounts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new Accounts();
        $query = Accounts::find()->where(['idinvoice'])->joinWith('elements')->orderBy('date_receive DESC');
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewin($id, $idinvoice)
    {
        $model = new Accouts();
        
        $query = Accounts::find()->where(['idinvoice' => $idinvoice])->joinWith('elements')->orderBy('date_receive DESC');
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionViewreceipt($id)
    {
        $model = new Receipt;
        
        return $this->render('viewreceipt', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionCreatereceipt($idord, $idel)
    {
        $model = new Receipt();
        $modelacc = new Accounts();
        $model->id = $idel;
        $model->idinvoice = $idord;
    //    $modelacc->status = '3';
       // $modelel = new Elements();
        $transaction=$model->getDb()->beginTransaction();
         try
            {
                if ($model->load(Yii::$app->request->post())) {
                    Yii::$app->db->createCommand()->update('accounts', ['status' => Accounts::ACCOUNTS_ONSTOCK],['idord' => $model->idinvoice])->execute();
                    Yii::$app->db->createCommand()->update('elements', ['quantity' => new Expression('quantity + :modelquantity', [':modelquantity' => $model->quantity])],['idelements' => $model->id])->execute();
                 // Yii::$app->db->createCommand()->update('requests', ['status' => Requests::REQUEST_DONE],['id' => $model->id])->execute(); //change status in requests through purchaseorder
                    
                    if ($model->save()) { 
                        $transaction->commit();
                        
                        return $this->redirect(['paymentinvoice/index']);
                      }
          
                   
                }
            }
         catch(Exception $e) // an exception is raised if a query fails
            {
                $transaction->rollback();
            }
            
            return $this->render('createreceipt', [
                'model' => $model,
                'modelacc' => $modelacc,
              //  'modelel' => $modelel,
            ]);
        
    }
    
    public function actionChangeinvoice($idinvoice)
    {
       // $model = new Accounts();
        $model = $this->findModel($idinvoice);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idunit]);
        } else {
            return $this->render('changeinvoice', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionShortage()
    {
        $model = new Accounts();
        $searchModel = new AccountsSearch();
        
        $modelelem = new Elements();
        $searchModelelement = new Elements();
        
        $query = Accounts::find()->where(['status' => '2'])->joinWith('elements')->orderBy('date_receive DESC');
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
           return $this->render('shortage',[
            'model' => $model,
            'modelelem' => $modelelem,
            'searchModel' => $searchModel,
            'searchModelelement' => $searchModelelement,
            'dataProvider' =>$dataProvider,
        ]);
    }
    /**
     * Creates a new Accounts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Accounts();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = '2';
            $model->save();
            return $this->redirect(['view', 'id' => $model->idord]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateitem($idinvoice)
    {
        $model = new Accounts();
        $modelpurchase = new Purchaseorder();
        $model->idinvoice = $idinvoice;
        $model->delivery = '1 week';
        $model->date_receive = $modelpurchase->date;
        
        $modelAccountsRequests = new AccountsRequests();
       
        $modelel = new Elements();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = '2';
            $modelpurchase->idelement = $model->idelem;
            $bResult = $model->save(false);
            
            $modelAccountsRequests->requests_id = intval($_POST['AccountsRequests']['requests_id']);
            $modelAccountsRequests->accounts_id = $model->idord;
            $modelAccountsRequests->save();
            
            if($bResult){
                Yii::$app->session->setFlash('success', 'Товар успешно добавлен в счет!');
                return $this->redirect(['paymentinvoice/itemsin', 'idinvoice' => $model->idinvoice]);
            }
        } else {
            return $this->render('createitem', [
                'model' => $model,
                'modelpurchase' => $modelpurchase,
                'modelAccountsRequests' => $modelAccountsRequests,
            ]);
        }
    }
    
    public function actionCreatein($id)
    {
        $model = new Paymentinvoice();
        $model->idpaymenti = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->status = '2';
            $model->save();
            return $this->redirect(['view', 'id' => $model->idpaymenti]);
        } else {
            return $this->render('createin', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAddtoinvoice($idel, $idprice)
    {
        $model = new Accounts();
        $modelpr = new Prices();
        $model->idelem = $idel;
        $model->idprice = $idprice;
        
        if ($model->load(Yii::$app->request->post()) && $modelpr->save()) {
            Yii::$app->session->setFlash('success', 'Данная позиция успешно добавлена в счет!');
            return $this->redirect(['paymentinvoice/itemsin', 'id' => $model->idinvoice]);
        }else {
            return $this->render('addtoinvoice', [
                'model' => $model,
                //'modelpr' => $modelpr,
            ]);
        }
    }
    
    public function actionAddToAccount($accounts_id, $requests_id)
    {        
        //checking a valid Accounts Id
        $modelAccounts = Accounts::findOne($accounts_id);
        if(is_null($modelAccounts)) {
            return $this->redirect(['paymentinvoice/index']);
        }
        
        //checking a valid Request Id
        $modelRequests = Requests::findOne($requests_id);
        if(is_null($modelRequests)) {
            return $this->redirect(['paymentinvoice/index']);
        }
        
        $modelAccountsRequests = AccountsRequests::find()->where(['accounts_id' => $accounts_id, 'requests_id' => $requests_id])->limit(1)->one();
        if(is_null($modelAccountsRequests)) {
            $modelAccountsRequests = new AccountsRequests();
            $modelAccountsRequests->accounts_id = $accounts_id;
            $modelAccountsRequests->requests_id = $requests_id;
            $modelAccountsRequests->quantity = 0;
            $modelAccountsRequests->save();
        }
        
        return $this->redirect(['accounts/addrequest', 'idinvoice' => $modelAccounts->idinvoice, 'idrequest' => $requests_id]);
    }

    public function actionAddrequest($idinvoice, $idrequest)
    {
        //checking a valid Paymentinvoice Id
        $modelPaymentinvoice = Paymentinvoice::findOne($idinvoice);
        if(is_null($modelPaymentinvoice)) {
            return $this->redirect(['paymentinvoice/index']);
        }
        
        //checking a valid Request Id
        $modelRequests = Requests::findOne($idrequest);
        if(is_null($modelRequests)) {
            return $this->redirect(['paymentinvoice/index']);
        }
        
        //checking if a request has an Element Id
        if(is_null($modelRequests->estimated_idel)) {
            $modelElements = Elements::find()->where(['name' => $modelRequests->name])->limit(1)->one();
            if(!is_null($modelElements)) {
                $modelRequests->estimated_idel = $modelElements->idelements;
            }
        }
        
        $modelPrices = new Prices(['scenario' => Prices::SCENARIO_REQUEST_BY_ID]);
        $modelPrices->idel = $modelRequests->estimated_idel;
        $modelPrices->idsup = $modelPaymentinvoice->idsupplier;
        //defaul values for creating new price
        $modelPrices->usd = $modelPaymentinvoice->usd;
        $modelPrices->pdv = '20%';
        $modelPrices->forUP = '1';
        $modelPrices->idcurrency = '1';
        

        $modelAccounts = new Accounts(['scenario' => Accounts::SCENARIO_REQUEST_BY_ID]);
        $modelAccounts->idinvoice = $modelPaymentinvoice->idpaymenti;
        $modelAccounts->idelem = $modelRequests->estimated_idel;
        $modelAccounts->status = Accounts::ACCOUNTS_ORDERED;
        $modelAccounts->delivery = '1 week';
        $modelAccounts->date_receive = date('Y-m-d', time() + (86400 * 8));

        if ($modelPrices->load(Yii::$app->request->post()) && $modelAccounts->load(Yii::$app->request->post()) && $modelPrices->validate() && $modelAccounts->validate()) {

            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();

            try {
                $modelPrices->idel = $modelAccounts->idelem;
                $modelPrices->save(false);

                $modelAccounts->idprice = $modelPrices->idpr;
                $modelAccounts->save(false);
                
                $modelRequests->status = strval(Requests::REQUEST_ACTIVE);
                $modelRequests->estimated_idel = $modelAccounts->idelem;
                $modelRequests->save();
                
//Yii::$app->db->createCommand()->update('requests', ['status' => Requests::REQUEST_ACTIVE],['idrequest' => $modelRequests->idrequest])->execute();

                $modelAccountsRequests = new AccountsRequests();
                $modelAccountsRequests->accounts_id = $modelAccounts->idord;
                $modelAccountsRequests->requests_id = $modelRequests->idrequest;
                $modelAccountsRequests->quantity = 0;
                $modelAccountsRequests->save();
                
                //making a record in purchaseorder table
                $modelPurchaseorder = new Purchaseorder();
                $modelPurchaseorder->idrequest = $modelRequests->idrequest;
                $modelPurchaseorder->idelement = $modelRequests->estimated_idel;
                $modelPurchaseorder->quantity = $modelAccounts->quantity;
                $modelPurchaseorder->date = $modelAccounts->date_receive;
                $modelPurchaseorder->save();

                $transaction->commit();

                if (Amounts::checkAmount($modelPrices, $modelAccounts)) {
                    Yii::$app->session->setFlash('success', 'Данная позиция успешно добавлена в счет!');
                } else {
                    Yii::$app->session->setFlash('warning', 'Данная позиция успешно добавлена в счет! Но общая сумма не совпадает с расчетной.');
                }
                return $this->redirect(['paymentinvoice/itemsin', 'idinvoice' => $modelPaymentinvoice->idpaymenti]);
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch(\Throwable $e) {
                $transaction->rollBack();
            }
            
        } //if ($modelPrices->load(Yii::$app->request->post()) 
       
        return $this->render('addrequest', [
            'modelAccounts' => $modelAccounts,
            'modelPaymentinvoice' => $modelPaymentinvoice,
            'modelRequests' => $modelRequests,
            'modelPrices' => $modelPrices,
            'providerAccountsForRequest' => new ActiveDataProvider([
                'query' => AccountsRequests::getAccountsForRequest(
                    $modelPaymentinvoice->idpaymenti, 
                    $modelRequests->idrequest, 
                    $modelRequests->estimated_idel
                ),
            ]),
        ]);
    }

    public function actionAdditemquick($idel)
    {
        $model = new Accounts();
        $modelpay = new Paymentinvoice();
        $model->idelem = $idel;
        $model->idinvoice = $modelpay->idpaymenti;
        $model->status = Accounts::ACCOUNTS_ORDERED;
        
       // $model->status = Accounts::ACCOUNTS_ORDERED;
        
        $modelpr = new Prices();
        $modelpr->idel = $idel;
        $modelpr->idsup = $modelpay->idsupplier;
        //defaul values for create new price
        $modelpr->usd = '26.4';
        $modelpr->pdv = '20%';
        $modelpr->forUP = '1';
        $modelpr->idcurrency = '1';
       
           
        if ($model->load(Yii::$app->request->post()) && $modelpr->load(Yii::$app->request->post())) { ///*Yii::$app->request->isAjax*/
            $modelpr->idel = $model->idelem;
            $modelpr->idpr = $model->idprice;

            $transaction = $model->getDb()->beginTransaction(
                 //   Transaction::SERIALIZABLE
                    );
            try{
              //  $valid = $model->validate();
               // $valid = Model::validateMultiple($modelpr) && $valid;
             //   Yii::$app->db->createCommand()->update('accounts', ['status' => Accounts::ACCOUNTS_ORDERED],['idelem' => $idel])->execute();
                if ($model->validate() && $modelpr->validate()) {
                    $modelpr->save();
                    $model->save();

                    $transaction->commit();
                  
               //      Yii::$app->response->format = Response::FORMAT_JSON;
                    Yii::$app->session->setFlash('success', 'Данная позиция успешно добавлена в счет!');
                    return $this->redirect(['accounts/viewitem', 'idpo' => $model->idpo]);
                }else {
                    $transaction->rollBack();
                }  
            }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
           
        } else {
           //  var_dump($modelpr->getErrors());
            return $this->render('additemquick', [ //_formaddfast
                'model' => $model,
                'modelpr' => $modelpr,
                'modelpay' => $modelpay
            ]);
        }  
    }

    /**
     * Updates an existing Accounts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$accounts = new Accounts();
        $receipt = new Receipt();
        $receipt->idinvoice = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->idord = $receipt->idinvoice;
            $model->idelem = $receipt->id;
            
          //  if(!$model->save()) throw new NotFoundHttpException('Страница не сохранена');
            $model->save();
            return $this->redirect(['receipt/create', 'id' => $model->idord, $model->idord = $receipt->idinvoice, $model->idelem = $receipt->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'receipt' => $receipt,
            ]);
        }
    }

    /**
     * Deletes an existing Accounts model.
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
     * Finds the Accounts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accounts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accounts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
