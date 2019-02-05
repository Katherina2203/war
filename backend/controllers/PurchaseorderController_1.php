<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Purchaseorder;
use backend\models\PurchaseorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Prices;
use backend\models\PricesSearch;
use common\models\Requests;
/**
 * PurchaseordeController implements the CRUD actions for Purchaseorder model.
 */
class PurchaseorderController extends Controller
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
                    'roles' => ['head', 'admin', 'PurchasegroupAccess'],
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
     * Lists all Purchaseorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $modelrequest = new Requests();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelrequest' => $modelrequest,
        ]);
    }

    /**
     * Displays a single Purchaseorder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $modelpr = new Prices();
        
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelpr' => $modelpr,
        ]);
    }
    
    public function actionViewitem($id)
    {
        $modelpr = new Prices();
        $model = new Purchaseorder();
     //   $model = $this->findModel($id);
        
    /*    if ($modelpr->load(Yii::$app->request->post())) {
            $model->idelement = $modelpr->idel;
            $modelpr->save();
        }else{}*/
        
        return $this->render('viewitem', [
            'model' => $this->findModel($id),
            'modelpr' => $modelpr,
            
        ]);
    }

    /**
     * Creates a new Purchaseorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idrequest = null)
    {
        $model = new Purchaseorder();
        $model->idrequest = $idrequest;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->idrequest]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
     public function actionCreaterequest()
    {
        $model = new Purchaseorder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpo, 'idrequest' => $model->idrequest]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionViewprice($idelement)
    {
        $model = new Prices();
        $searchModel = new PricesSearch();
        
        $query = Prices::find()->where(['idel' => $idelement]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('viewprice', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAddtoinvoice()
    {
      //  $modelaccou
        return $this->redirect('index',[
            
        ]);
    }

    /**
     * Deletes an existing Purchaseorder model.
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
     * Finds the Purchaseorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchaseorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchaseorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
