<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\Accounts;
use backend\models\AccountsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;

use \common\models\Receipt;
use backend\models\ReceiptSearch;
use common\models\Elements;
use backend\models\ElementsSearch;
use common\models\Prices;

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
        $model->idinvoice = $idinvoice;

        if ($model->load(Yii::$app->request->post())) {
            $model->status = '2';
            $model->save();
            return $this->redirect(['view', 'id' => $model->idord]);
        } else {
            return $this->render('createitem', [
                'model' => $model,
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
