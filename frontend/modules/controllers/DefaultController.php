<?php
namespace frontend\modules\controllers;

use yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use common\models\Requests;
use backend\models\RequestsSearch;
use common\models\Paymentinvoice;
use common\models\Processingrequest;
use common\models\Supplier;
use backend\models\ElementsSearch;
use common\models\Themes;


/**
 * Default controller for the `myaccount` module
 */
class DefaultController extends Controller
{
   
    public $layout = '/myaccount';
    
     /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $modelrequests = new Requests();
        $modelproc = new \common\models\Processingrequest();
        $searchModelreq = new RequestsSearch();
        $searchElements = new ElementsSearch();
        
        
        $query = Requests::find()->where(['status' => '0'])->andWhere(['iduser' => yii::$app->user->identity->id])->orderBy('created_at DESC'); //->orderBy('created_at DESC')->all();
        $dataProviderreq = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'pageSize' => 6,
            ]
        ]);
        
        if ($modelrequests->load(Yii::$app->request->post())) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
               if($modelrequests->save()){
                Yii::$app->session->setFlash('success', 'Заявка успешно сохранена');
                 return $this->redirect(['view', 'id' => $modelrequests->idrequest]);
           }
        } 
        /*else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
      //  if($modelrequests->idrequest != $modelproc->idrequest){
        $dataProviderconf = new ActiveDataProvider([
            'query' => Requests::find()->where(['status' => '0'])->asArray(),
        ]);
         $modelpay = new Paymentinvoice();

        $dataProviderpay = new ActiveDataProvider([
            'query' =>  Paymentinvoice::find()->where(['date_payment' => NULL])->asArray(),
        ]);
        //end view invoices
        
        
        $queryTheme = Themes::find()->where(['status' => 'active'])->orderBy('created_at DESC');
        $dataProviderTheme = new ActiveDataProvider([
            'query' => $queryTheme,
        ]);
        $searchModelTheme = new \backend\models\ThemesSearch;
        $modelTheme = new Themes();
        
        return $this->render('index', [
            'modelrequests' => $modelrequests,
            'modelpay' => $modelpay,
            'modelTheme' => $modelTheme,
            'searchModelreq' => $searchModelreq,
            'dataProviderreq' => $dataProviderreq,
           // 'dataProviderconf' => $dataProviderconf,
            'dataProviderpay' => $dataProviderpay,
            'dataProviderTheme'=>$dataProviderTheme,
            'searchElements' => $searchElements,
            'searchModelTheme'=>$searchModelTheme
            ]);
    }
    /*
     * View instruction page in main module
     */
    public function actionInstruction()
    {
         return $this->render('instruction');
    }
    
    
    
    
}
