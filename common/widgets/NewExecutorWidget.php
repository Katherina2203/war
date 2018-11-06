<?php
namespace common\widgets;

//use \yii\bootstrap\Widget;
use yii;
use kartik\base\Widget;
use yii\data\ActiveDataProvider;

use common\models\Processingrequest;
use backend\models\ProcessingrequestSearch;
use common\models\Requests;
use backend\models\RequestsSearch;

class NewExecutorWidget extends Widget
{
    public function run() 
    {
        $modelrequest = new Requests();
        $searchmodelrequest = new RequestsSearch();
        //$modelproces->idrequest = $idreq;
    /*    $queryrequest = Requests::find()->all(); //->orderBy('created_at DESC') ->where(['status' => '0'])
        $dataProviderrequest = new ActiveDataProvider([
           'query' => $queryrequest,
        ]);*/
         $dataProviderrequest = $searchmodelrequest->search(Yii::$app->request->queryParams);
        
     
    //  $models = \common\models\Category::find()->where(['parent'=> 0])->All();
       return $this->render('confnewexecutor', [
            'modelrequest' => $modelrequest,
          //  'modelproces'=> $modelproces,
          //  'dataProviderproces' => $dataProviderproces,
            'dataProviderrequest' => $dataProviderrequest,
           // 'searchmodelproces' => $searchmodelproces,
            'searchmodelrequest' => $searchmodelrequest,
           ]);
    }
   
}

