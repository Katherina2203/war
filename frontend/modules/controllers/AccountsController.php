<?php

namespace frontend\modules\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

use common\models\Accounts;
use backend\models\AccountsSearch;
use common\models\Receipt;
use backend\models\ReceiptSearch;
use common\models\Elements;
use backend\models\ElementsSearch;

/**
 * AccountsController implements the CRUD actions for Accounts model.
 */
class AccountsController extends Controller
{
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
                    'roles' => ['head', 'admin', 'Purchasegroup'],
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
    
    public function actionIndex()
    {
        $model = new Accounts();
        $searchModel = new AccountsSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $queryacc = Accounts::find()->with(['paymentinvoice'])->orderBy('date_receive DESC'); //->where(['idinvoice' => $model->idinvoice])
        $dataProvider = new ActiveDataProvider([
            'query' => $queryacc,
        ]);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
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
    
    public function actionShortage()
    {
        $model = new Accounts();
        $searchModel = new AccountsSearch();
        
        $modelelement = new Elements();
        $searchModelelement = new ElementsSearch();
        
        $query = Accounts::find()->where(['status' => '2'])->joinWith('elements')->orderBy('date_receive DESC');
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
           return $this->render('shortage',[
            'model' => $model,
            'modelelement' => $modelelement,
            'searchModel' => $searchModel,
            'searchModelelement' => $searchModelelement,
            'dataProvider' =>$dataProvider,
        ]);
    }
    
       public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$accounts = new Accounts();
        $receipt = new Receipt();
        $receipt->idinvoice = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->idord = $receipt->idinvoice;
            $model->idelem = $receipt->id;
            $model->update();
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
    
    protected function findModel($id)
    {
        if (($model = Accounts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
