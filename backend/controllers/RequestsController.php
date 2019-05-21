<?php

namespace backend\controllers;

use Yii;
use common\models\Requests;
use backend\models\RequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


use common\models\Processingrequest;
use backend\models\ProcessingrequestSearch;
use common\models\Elements;
use backend\models\ElementsSearch;
use common\models\Purchaseorder;
use backend\models\PurchaseorderSearch;
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
                'only' => ['index', 'view','create'],
                'rules' => [
                    [
                      //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['myrequests'],
                    //    'roles' => ['updateOwnPost'],
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
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $modelPurchase = new Purchaseorder();
       
    /*    if($model->status == '0'){
            $modelPurchase
        }*/
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        
        $modelTheme = new Themes();
        $modelSupp = new Supplier();
        $modelUser = new Users();

        return $this->render('index', [
            'model' => $model,
            'modelPurchase' => $modelPurchase,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelTheme' => $modelTheme,
            'modelSupp' => $modelSupp,
            'modelUser' => $modelUser,
        ]);
    }
    
    /**
     * Lists all my Requests models.
     * @return mixed
     */
    public function actionMyrequests($iduser)
    {
        
       // if($model->iduser = '0'){
        $searchModel = new RequestsSearch();
        $model = new Requests();
        $model->iduser = $iduser;
            
        $query = Requests::find()->with(['themes', 'supplier'])->where(['iduser' => $iduser])->orderBy(['created_at DESC'])->orderBy('status ASC')->limit(20);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $modelTheme = new Themes();
        $modelSupp = new Supplier();
        
        return $this->render('myrequests', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelTheme' => $modelTheme,
            'modelSupp' => $modelSupp,
        ]);
      //  }else{
      //      \yii::info("В настоящее время у вас нет заявок");
           //  throw new NotFoundHttpException('В настоящее время у вас нет заявок.');
             
      //  }
        
    }
    
    /**
     * Displays Requests where can check the executer.
     * 
     * @return mixed  requests and processingrequests
     */
    
    public function actionCheckprocess()
    {
        $model = new Requests();
        $searchModel = new RequestsSearch();
      //  $modelproc = new Processingrequest();
       // $modelproc->idrequest = $request;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      /*  $query = Requests::find()->with(['themes', 'supplier'])->where(['status' => '0'])->orderBy(['created_at DESC', ])->orderBy('status ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);*/

        return $this->render('checkprocess', [
            'model' => $model,
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
        
        $searchModelHistory = new RequestStatusHistorySearch;
        $dataProviderHistory = $searchModelHistory->search(Yii::$app->request->queryParams);
        
        
        
        return $this->render('view', [
            'model' => $model,
            'searchModelorder' => $searchModelorder,
          //  'dataProviderorder' => $dataProviderorder,
            'searchModelHistory' => $searchModelHistory,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderel' => $dataProviderel,
            'dataProviderHistory' => $dataProviderHistory,
           // 'dataProviderinvoice' => $dataProviderinvoice,
            'modelorder' => $modelorder,
            'modelelement' => $modelelement,
            'modelinvoice' => $modelinvoice,
            'modelacc' => $modelacc,
            
        ]);
    }

    /**
     * Creates a new Requests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 /*   public function actionCreate($iduser = null)
    {
        $model = new Requests();
        $model->iduser = $iduser;
        
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/requests/';

        if ($model->load(Yii::$app->request->post())) {
            $model->status = '0';
            $img = UploadedFile::getInstance($model, 'img');
             
            $model->img = $img->name;
            $ext = end((explode(".", $img->name)));

         
            
           // $model->save();
            $path = Yii::$app->params['uploadPath'] . $model->img;
             if($model->save()){
            $img->saveAs($path);
            Yii::$app->session->setFlash('success', 'Image uploaded successfully');
            return $this->redirect(['view', 'id'=>$model->idrequest]);

        } else {
            Yii::$app->session->setFlash('error', 'Fail to save image');
        }
        
            return $this->redirect(['view', 'id' => $model->idrequest]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        
    }*/
    
   public function actionCreate($iduser = null)
    {
        $model = new Requests();
        $model->iduser = $iduser;
        $model->status = '0';
        $model->idtype = '1';
            
        if($model->load(Yii::$app->request->post())){
        
            $img = UploadedFile::getInstance($model, 'img');
         
            if($img && $img->tempName){
                $model->img = $img;
         
                if($model->img && $model->validate(['img'])){
                    $dir = Yii::getAlias('@frontend/'). 'images/requests/';
                    $imgPath = $model->img->baseName .  '.' . $model->img->extension;
                    $model->img->saveAs($dir . $imgPath); //$model->img->extension
                    $model->img = 'images/requests/'. $imgPath;
        //{$model->id}/{$model->media_file->name}
                } 
            }

           if($model->save(false)){
             
                Yii::$app->session->setFlash('success', 'Заявка успешно сохранена');
                return $this->redirect(['view', 'id'=>$model->idrequest]);
           }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
   
    
    public function actionCreatequick($iduser)
    {
        $model = new Requests();
        $model->iduser = $iduser;
        
        $modelel = new Elements();
        
         if ($model->load(Yii::$app->request->post())){
            $model->iduser = \yii::$app->user->identity->id;
         
            
            $model->name = $modelel->name;
            $model->description = $modelel->name;
            $model->idproduce = $modelel->idproduce;
            $model->type = $modelel->idcategory;
  
            
        $model->save();
            Yii::$app->session->setFlash('success', 'Requests sent successfully');
            return $this->redirect(['view', 
                'id' => $model->idrequest
                ]);
        
         }else {
              return $this->render('create', [
                'model' => $model,
                'model' => $modelel,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->img = UploadedFile::getInstance($model, 'img');
            
           if ($img && $img->tempName) {
                $model->img = $img;
                
                if ($model->img && $model->validate(['img'])) {  
                
                    $dir = Yii::getAlias('@frontend/images/requests/');
                    $model->img->saveAs($dir.$model->img->baseName .  '.' . $model->img->extension);
                    $model->img = $model->img->baseName .  '.' . $model->img->extension;
                }
           }
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
     * Deletes an existing Requests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
    
    public function actionChangestatus()
    {
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $modelTheme = new Themes();
        $modelSupp = new Supplier();
        $modelUser = new Users();

        return $this->render('changestatus', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelTheme' => $modelTheme,
            'modelSupp' => $modelSupp,
            'modelUser' => $modelUser,
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
