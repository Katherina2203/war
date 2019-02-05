<?php
namespace app\modules\admin\controllers;

use Yii;
use common\models\Receipt;
use backend\models\ReceiptSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

use common\models\Accounts;
use common\models\Requests;
use common\models\Purchaseorder;
/**
 * ReceiptController implements the CRUD actions for Receipt model.
 */
class ReceiptController extends Controller
{
  /*  public function beforeSave($insert) 
    {
    if (parent::beforeSave($insert)) {
        
    $this->update([
        
    ]);
        Accounts::('status = 3');
        Requests::('status = 3');
 
        return true;
    }else{
        return false;
    }*/

    /**
     * @inheritdoc
     */
    
    /*
     * request->status = выполнено, только тогда, когда количество reciept.quantity== запрашиваемому(согласованному)
     * и  тоже самое и менять статус в accounts
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
     * Lists all Receipt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receipt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionLastreceive()
    {
        $model = new Receipt();
        $searchModel = new ReceiptSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('lastreceive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Receipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receipt();

       
            $transaction=$model->getDb()->beginTransaction();
            try
            {
                if ($model->load(Yii::$app->request->post())) {
                    
                    Yii::$app->db->createCommand()->update('accounts', ['status' => Accounts::ACCOUNTS_ONSTOCK],['idord' => $model->idinvoice])->execute();
                    Yii::$app->db->createCommand()->update('elements', ['quantity' => new Expression('quantity + :modelquantity', [':modelquantity' => $model->quantity])],['idelements' => $model->id])->execute();
                  //  Yii::$app->db->createCommand()->update('requests', ['status' => Requests::REQUEST_DONE],['id' => $model->id])->execute(); //change status in requests through purchaseorder
                      if ($model->save()) { // <- update stock here
                        $transaction->commit();
                        
                        return $this->redirect(['view', 'id' => $model->idreceipt]);
                      }
        
                   // $transaction->commit();
                 //   Yii::$app->session->setFlash('success', 'Статус успешно изменен');
                  //  return $this->redirect(['view', 'id' => $model->idreceipt]);
                }  
            }
                     
              //  $connection->createCommand($sql1)->execute();
              //  $connection->createCommand($sql2)->execute();
                //.... other SQL executions
                
            
            catch(Exception $e) // an exception is raised if a query fails
            {
                $transaction->rollback();
            }
            
            return $this->render('create', [
                         'model' => $model,
                    ]);
         
    }

    /**
     * Updates an existing Receipt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idreceipt]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Receipt model.
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
     * Finds the Receipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Receipt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
