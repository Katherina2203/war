<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\db\Expression;

use common\models\Processingrequest;
use backend\models\ProcessingrequestSearch;
use common\models\Purchaseorder;
use backend\models\PurchaseorderSearch;
use common\models\Users;
use backend\models\UsersSearch;
use common\models\Requests;
use backend\models\RequestsSearch;
use common\models\Elements;
use backend\models\ElementsSearch;

/**
 * ProcessingrequestController implements the CRUD actions for Processingrequest model.
 */
class ProcessingrequestController extends Controller
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
                        'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
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
     * Lists all Processingrequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcessingrequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionExecutors()
    {
        $searchModel = new ProcessingrequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchRequest = new RequestsSearch();
        $modelRequest = new Requests();
         
        return $this->render('executors', [
            'searchModel' => $searchModel,
            'searchRequest' => $searchRequest,
            'dataProvider' => $dataProvider,
            'modelRequest' => $modelRequest,
        ]);
    }
    
    /**
     * Lists all Processingrequest models.
     * @return mixed
     */
    
    public function actionByexecutor($iduser)
    {
        $model = new Processingrequest();
        $searchModel = new ProcessingrequestSearch();
        $user = new Users();
        $searchUsers = new UsersSearch();
        $searchRequest = new RequestsSearch();
        $modelRequest = new Requests();
        $modelPurchase = new Purchaseorder();
        
       $query = Processingrequest::find()
                ->select(['{{%processingrequest}}.*', 'purchaseorder_count' => new Expression('COUNT({{%purchaseorder}}.idpo)')])
                ->joinWith(['purchaseorder'], false)
                ->with(['requests'])
                ->where(['idpurchasegroup' => $iduser])
                ->orderBy('idrequest DESC')
                ->groupBy(['{{%processingrequest}}.idprocessing']);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('byexecutor', [
            'searchModel' => $searchModel,
            'searchRequest' => $searchRequest,
            'searchUsers' => $searchUsers,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'modelRequest' => $modelRequest,
            'modelPurchase' => $modelPurchase,
            'user' => $user,
        ]);
    }
    
    public function actionVieworder($idrequest)
    {
        $modelorder = new Purchaseorder();
        $searchModelorder = new PurchaseorderSearch();
        
        $query = Purchaseorder::find()->where(['idrequest' => $idrequest]);
        $dataProviderorder = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('vieworder',[
            'modelorder' => $modelorder,
            'dataProviderorder' => $dataProviderorder,
            'searchModelorder' => $searchModelorder,
        ]);
    }
    /**
     * Displays a single Processingrequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Processingrequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Processingrequest();
        //$modelproc->idrequest = $request;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idprocessing]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAdditem($idrequest, $idel=NULL)
    {
        $modelord = new Purchaseorder();
        $modelreq = new Requests();

        $modelord->idrequest = $idrequest;
        $modelreq->estimated_idel = $idel;
      //  $modelreq->estimated_idel = $modelord->idelement;
        if($modelreq->estimated_idel != NULL){
            $modelord->idelement =  $idel;
        }
        /*else{
            $modelord->idelement = NULL;
        }*/
     
        if ($modelord->load(Yii::$app->request->post())) {
          //  $modelord->idelement =  $modelreq->estimated_idel;
            
            $transaction = $modelord->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(
                 //   Transaction::SERIALIZABLE
                    );
            try{
                $valid = $modelord->validate();
                 Yii::$app->db->createCommand()->update('requests', ['status' => Requests::REQUEST_ACTIVE],['idrequest' => $modelord->idrequest])->execute();
                 
                if ($valid) {
                    $modelord->save();
                    
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Статус заявки успешно изменен на Активный');
                    return $this->redirect(['purchaseorder/viewitem', 'idpo' => $modelord->idpo]);
                }else {
                    $transaction->rollBack();
                }  
            }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
           
        } else {
            return $this->render('additem', [
                    'modelord' => $modelord,
                    'modelreq' => $modelreq,
            ]);
        }
           

    }
    
    public function actionChangestatus()
    {
        
    }
    
       public function actionCreateExecute($idrequest)
    {
        $model = new Processingrequest();
        $modelproc->idrequest = $idrequest;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idprocessing]);
        } else {
            return $this->render('createExecute', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Processingrequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idprocessing]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Processingrequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionReport()
    {
        $searchModel = new ProcessingrequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        
        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the Processingrequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Processingrequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Processingrequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
