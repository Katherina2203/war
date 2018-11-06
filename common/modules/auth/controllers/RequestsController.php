<?php

namespace common\modules\auth\controllers;

use Yii;
use common\models\Requests;
use backend\models\RequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

use common\models\Processingrequest;
use backend\models\ProcessingrequestSearch;
use common\models\Purchaseorder;
use backend\models\PurchaseorderSearch;
use common\models\Elements;
use common\models\Accounts;
use common\models\Paymentinvoice;
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
       $behaviors['access'] = [
             'class' => AccessControl::className(),
             'rules' => [
                 [
                         'allow' => true,
                         'roles' => ['admin', 'auth'],
                         'matchCallback' => function ($rule, $action) {
                        
                        $module = Yii::$app->controller->module->id; 
                        $action = Yii::$app->controller->action->id;
                        $controller = Yii::$app->controller->id;
                        $route  = "$module/$controller/$action";
                        $post = Yii::$app->request->post();
                        if (\yii::$app->user->can($route)) {
                             return true;
                        }
                        }
                 ],
             ],
           ];

 

        return $behaviors;
    }

    /**
     * Lists all Requests models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
        $modelorder = new Purchaseorder();
        $searchModelorder = new PurchaseorderSearch;
        $modelelement = new Elements();
        $modelinvoice = new Paymentinvoice();
        $modelacc = new Accounts;
        
     /*   $queryinv = Paymentinvoice::find()->where(['idpaymenti' => 34]); //$modelacc->idinvoice
        $dataProviderinvoice = new ActiveDataProvider([
            'query' => $queryinv,
        ]);*/
        
        $queryel = Elements::find();
        $dataProviderel = new ActiveDataProvider([
            'query' => $queryel,
        ]);
        
        $query = Purchaseorder::find()->where(['idrequest' => $id]);
        $dataProviderorder = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        
        $queryacc = Accounts::find()->where(['idelem' => $modelorder->idelement]); //['idelem' => 3556] ['idelem' => $modelorder->idelement]
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModelorder' => $searchModelorder,
            'dataProviderorder' => $dataProviderorder,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderel' => $dataProviderel,
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
     * @return mixed
     */
    public function actionCreate($iduser)
    {
        $model = new Requests();
        $model->iduser = $iduser;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idrequest]);
        } else {
            return $this->render('create', [
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idrequest]);
        } else {
            return $this->render('update', [
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

    public function actionViewprocess($idrequest)
    {
        $model = new Processingrequest();
        $searchModel = new ProcessingrequestSearch();
        
        $query = Processingrequest::find()->where(['idrequest' => $idrequest]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('viewprocess', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionMyrequests($iduser)
    {
        $modelrequest = new Requests();
        $modelrequest->iduser = $iduser;
        
        $modelorder = new Purchaseorder();
        $searchModelorder = new PurchaseorderSearch();
        
        $query = Purchaseorder::find()->where(['iduser' => $iduser]); //->where(['idrequest' => ]);
        $dataProviderorder = new ActiveDataProvider([
            'query' => $query,
        ]);
                
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('myrequests', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelorder' => $searchModelorder,
            'modelorder' => $modelorder,
            'dataProviderorder' => $dataProviderorder,
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
