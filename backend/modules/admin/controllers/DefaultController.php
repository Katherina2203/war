<?php

namespace app\modules\admin\controllers;

use frontend\components\Common;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;


use common\models\LoginForm;
use common\models\Requests;
use backend\models\RequestsSearch;
use common\models\Paymentinvoice;
use backend\models\ElementsSearch;
use common\models\Processingrequest;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
     
            'access' => [
                  'class' => AccessControl::className(),
                  'rules' => [
                      [
                          'actions' => ['error'],
                          'allow' => true,
                      ],
                      [
                          'actions' => ['index', 'instruction', 'projectshortcut'],
                          'allow' => true,
                          'roles' => ['@'],
                      ],
                  ],
              ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'language' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $modelrequests = new Requests();
        $modelproc = new Processingrequest();
        $searchModelreq = new RequestsSearch();
        $searchElements = new ElementsSearch();
        
        $query = Requests::find()->where(['status' => '0'])->with(['themes'])->orderBy('created_at DESC'); 
        $dataProviderreq = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'pageSize' => 6,
            ]
        ]);
        
      //  if($modelrequests->idrequest != $modelproc->idrequest){
        $dataProviderconf = new ActiveDataProvider([
            'query' => Requests::find()->where(['status' => '0'])->asArray(),
        ]);
         $modelpay = new Paymentinvoice();

        $dataProviderpay = new ActiveDataProvider([
            'query' =>  Paymentinvoice::find()->where(['date_payment' => NULL])->asArray(),
        ]);
        //end view invoices
        
        
        return $this->render('index', [
            'modelrequests' => $modelrequests,
            'modelpay' => $modelpay,
            'searchModelreq' => $searchModelreq,
            'dataProviderreq' => $dataProviderreq,
            'dataProviderconf' => $dataProviderconf,
            'dataProviderpay' => $dataProviderpay,
            'searchElements' => $searchElements,
        ]);
    }
    
    public function actionInstruction()
    {
         return $this->render('instruction');
    }
    
    public function actionProjectshortcut()
    {
        return $this->render('projectshortcut', [
          //  'model' => $this->findModel($id),
        ]);
         
    }

   
    
  /*  public function actionService()
    {
        $cache = \yii::$app->cache;
       // $cache = $locator->cache;
        
        $cache->set("test",1);
        
        print $cache->get("test");

    }
    
     public function actionEvent(){

        $component = new Common(); //yii::$app->common;
        $component->on(Common::EVENT_NOTIFY,[$component,'notifyAdmin']);
        $component->sendMail("test@domain.com","Test","Test text");
        $component->off(Common::EVENT_NOTIFY,[$component,'notifyAdmin']);

    }
*/
}
