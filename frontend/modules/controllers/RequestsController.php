<?php

namespace frontend\modules\controllers;

use Yii;
use common\models\Requests;
use backend\models\RequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

use common\models\Processingrequest;
use backend\models\ProcessingrequestSearch;
use common\models\Purchaseorder;
use backend\models\PurchaseorderSearch;
use common\models\Elements;
use common\models\Accounts;
use common\models\Paymentinvoice;
use common\models\Users;
use common\models\Themes;
use common\models\Supplier;
use common\models\RequestStatusHistory;
use backend\models\RequestStatusHistorySearch;
/**
 * RequestsController implements the CRUD actions for Requests model.
 */
class RequestsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
              //  'only' => ['create', 'update', 'delete'],
                'rules' => [
                 /*   [
                     //   'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    /*   'matchCallback' => function ($rule, $action) {
                            return date('d-m') === '31-10';
                        }*/
                 //   ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['myrequests','index', 'view','create'],
                        'roles' => ['updateOwnPost'],
                    ],
                    [
                        'actions' => ['checkprocess', 'changestatus', 'updatestatus', 'viewprocess', 'myrequests'],
                        'allow' => true,
                        'roles' => ['admin', 'PurchasegroupAccess', 'head'],
                    ],
                ]
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
     * Lists all Requests models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Requests();
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      /*  $query = Requests::find(); 
        $dataProvider = new ActiveDataProvider([
            'pagination' => ['pageSize' =>40],
            'query' => $query,
        ]);*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a Requests where haven't any executors.
     * @param integer $id
     * @return mixed
     */
    
    public function actionCheckprocess()
    {
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      /*  $dataProvider = new ActiveDataProvider([
          /*  'pagination' => [
                'pageSizeLimit' => [0, 50],
            ],*/
                
       //   ]);      
    
        return $this->render('checkprocess', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Requests model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //  $model = new Requests();
        $model = $this->findModel($id);
        $modelorder = new Purchaseorder();
        $searchModelorder = new PurchaseorderSearch;
        $searchModelHistory = new RequestStatusHistorySearch;
        $modelelement = new Elements();
        $modelinvoice = new Paymentinvoice();
        $modelacc = new Accounts;
        
       /*   $query = $model->getPurchaseorder()->andWhere(['idelement' => '3556']) ;//Purchaseorder::find()->where(['idrequest' => $id, 'idelement' => '3556']);
        $dataProviderorder = new ActiveDataProvider([
            'query' => $query,
        ]);*/
        
        /*view description in database  - view elements table through purchaseorder*/
        $queryel = $model->getElements();
        $dataProviderel = new ActiveDataProvider([
            'query' => $queryel,
        ]);

        /*view condition of request  - view accounts table through purchaseorder*/
        $queryacc = $model->getAccounts()->orderBy('date_receive DESC'); 
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
        
        $querystatushistory = $model->getRequestStatusHistory(); //how to orderBy??
        $dataProviderHistory = new ActiveDataProvider([
            'query' => $querystatushistory,
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'searchModelorder' => $searchModelorder,
         //   'dataProviderorder' => $dataProviderorder,
            'searchModelHistory' => $searchModelHistory,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderel' => $dataProviderel,
            'dataProviderHistory' => $dataProviderHistory,
         //   'dataProviderinvoice' => $dataProviderinvoice,
            'modelorder' => $modelorder,
            'modelelement' => $modelelement,
            'modelinvoice' => $modelinvoice,
            'modelacc' => $modelacc,
            
        ]);
    }

    /**
     * Creates a new Requests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * status by default = 0
     * @return mixed
     */
    public function actionCreate($iduser = null)
    {
        $model = new Requests();
        $model->iduser = $iduser;
        $model->status = '0';
        $model->idtype = '1';
      //  Yii::$app->params['uploadPath'] = realpath(Yii::$app->basePath) . '/images/requests/';
        
        if ($model->load(Yii::$app->request->post())) {
           
            $img = UploadedFile::getInstance($model, 'img');
         
            if ($img && $img->tempName) {
                $model->img = $img;
         
                if ($model->validate(['img'])){
                   // $dir = Yii::getAlias('@frontend/images/requests/');
                    $dir = Yii::$app->params['uploadPath'] = \yii::$app->basePath . '/images/requests/';
                    $imgPath = $model->img->baseName .  '.' . $model->img->extension;
                    $model->img->saveAs($dir . $imgPath); //$model->img->extension
                    $model->img = 'requests/' . $imgPath;
        //{$model->id}/{$model->media_file->name}
                } 
            }
        
          
           if($model->save()){
                 Yii::$app->session->setFlash('success', 'Заявка успешно сохранена');
            return $this->redirect(['view', 'id'=>$model->idrequest]);
           }

        
      } else {
         
            return $this->render('create', [
                'model' => $model,
            ]);
       
      }
    }
    public function actionCreatesupplier()
    {
        $model = new Supplier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->idsupplier]);
            echo 'supplier';
        } else {
            return $this->renderAjax('createsupplier', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateproduce()
    {
        $model = new Produce();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   return $this->redirect(['view', 'id' => $model->idpr]);
            echo 'produce';
        } else {
            return $this->renderAjax('createproduce', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Requests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if(!\yii::$app->user->can('updateOwnPost', ['post' => $model])){
            throw new \yii\web\ForbiddenHttpException('Вам сюда нельзя!!!!');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idrequest]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdatestatus($idrequest)
    {
        $model = $this->findModel($idrequest);
         
        if ($model->load(Yii::$app->request->post())) {
            $transaction = $model->getDb()->beginTransaction();
                try{
                $valid = $model->validate(); 
                
                Yii::$app->db->createCommand()->insert('request_status_history', ['idrequest' => $model->idrequest, 'status' => $model->status])->execute();
                    
                    if ($valid) {
                        $model->save(false);

                        $transaction->commit();
                         Yii::$app->session->setFlash('success', 'Статус успешно изменен');
                          return $this->redirect(['processingrequest/byexecutor', 'iduser' => yii::$app->user->identity->id]);
                    } else {
                       $transaction->rollBack();
                    }  
                }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
                }
        }else{
               return $this->render('updatestatus', [
                'model' => $model,
            ]);
        }
    }
    
     /**
     * Updates an existing Requests status.
     * If status changes is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChangestatus($idrequest)
    {
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $modelTheme = new Themes();
        $modelSupp = new Supplier();
        $modelUser = new Users();
        
        return $this->render('changestatus', [
            'model' => $this->findModel($idrequest),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelTheme' => $modelTheme,
            'modelSupp' => $modelSupp,
            'modelUser' => $modelUser,
        ]);
         
    }

    /**
     * Deletes an existing Requests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      //  $this->findModel($id)->delete();
        $model = $this->findModel($id);
        
        if(!\yii::$app->user->can('updateOwnPost', ['post' => $model])){
            throw new \yii\web\ForbiddenHttpException('Вам сюда нельзя!!!!');
        }

        $model->delete();
        return $this->redirect(['index']);
    }

    /*
    * Create new executor for request
    */
    public function actionViewprocess($idrequest, $iduser)
    {
        $request = Requests::findOne($idrequest);
        
        $modeluser = new Users();
       
        
        $model = new Processingrequest();
        $model->idresponsive = $iduser;
       
        $searchModel = new ProcessingrequestSearch();
        
        $query = Processingrequest::find()->where(['idrequest' => $idrequest]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->idrequest = $idrequest;
        //    $model->idresponsive = \yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['checkprocess', 'id' => $model->idrequest]);
        } else {
            return $this->render('editprocess', [
                'model' => $model,
                'modeluser' => $modeluser,
                'request' => $request,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    }
    
  
        public function actionMyrequests($iduser)
    {
        $searchModel = new RequestsSearch();
        $model = new Requests();
        $model->iduser = $iduser;
        //$statusactive = count($model->idrequest);
            
        $query = Requests::find()->where(['iduser' => $iduser])->orderBy('created_at DESC');//->orderBy('status ASC')
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('myrequests', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    protected function findModel($id)
    {
        if (($model = Requests::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
