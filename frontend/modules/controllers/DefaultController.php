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
use common\models\Boards;


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
        
        $statusactive = count($modelrequests->idrequest);
        
        
        $query = Requests::find()->where(['status' => '0'])->andWhere(['iduser' => yii::$app->user->identity->id])->orderBy('created_at DESC')->groupBy('status'); //->all();
        $dataProviderreq = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'pageSize' => 6,
            ]
        ]);
        
        $modelrequests->iduser = yii::$app->user->identity->id;
        $modelrequests->status = '0';
        $modelrequests->idtype = '1';
        
        if ($modelrequests->load(\yii::$app->request->post())) {
            
           // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
               if($modelrequests->save(false)) {
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
        
        $queryBoard = Boards::find()->where(['discontinued' => '1'])->andWhere(['current' => yii::$app->user->identity->id])->orderBy('created_at DESC');
        $dataProviderBoard = new ActiveDataProvider([
            'query' => $queryBoard,
        ]);
        $searchModelBoard = new \backend\models\BoardsSearch;
        $modelBoard = new Boards();
        
        return $this->render('index', [
            'modelrequests' => $modelrequests,
            'modelpay' => $modelpay,
            'modelTheme' => $modelTheme,
            'modelBoard' => $modelBoard,
            'searchModelreq' => $searchModelreq,
            'dataProviderreq' => $dataProviderreq,
           // 'dataProviderconf' => $dataProviderconf,
            'dataProviderpay' => $dataProviderpay,
            'dataProviderTheme' => $dataProviderTheme,
            'dataProviderBoard' => $dataProviderBoard,
            'searchElements' => $searchElements,
            'searchModelTheme' => $searchModelTheme,
            'searchModelBoard' => $searchModelBoard,
            'statusactive' => $statusactive
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
