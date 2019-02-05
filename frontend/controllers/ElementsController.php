<?php
namespace frontend\controllers;

use Yii;
use common\models\Elements;
use backend\models\elementsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Prices;
use backend\models\PricesSearch;
use common\models\Outofstock;
use backend\models\OutofstockSearch;
use \common\models\Receipt;
use backend\models\ReceiptSearch;

class ElementsController extends Controller{
   
    public function actionIndex()
    {
        $searchModel = new elementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }
    
      public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewprice($idel)
    {
        $model = new Prices;
        $searchModel = new PricesSearch;
        
        $query = Prices::find()->where(['idel' => $idel])->orderBy('created_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('viewprice', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTostock($idelement)
    {
        $model = $this->findModel($idelement);
        $el = Elements::findOne($idelement);
        $add = new Receipt();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $add->id = $model->idelements;
        
        $el->quantity = $el->quantity + $add->quantity;
        
        $el->quantity->save();
        return $this->redirect('tostock', [
            'model' => $model,
        ]);
        
        }
    }
    
    public function actionFromstock($idelement)
    {
        $modelitem = Elements::findOne($idelement);
        $model = new Outofstock();
  
        if ($model->load(Yii::$app->request->post())) {
        $model->idelement = $modelitem->idelements;
        $modelitem->quantity = $quantity;
        $model->quantity = $quantity - $modelitem->quantity;
        $modelitem->save();

        return $this->redirect('view', [
            'idelement' => $modelitem->idelements,
            ]);
        }
        if ($modelitem->load(Yii::$app->request->post()) && $modelitem->save()) {
            return $this->redirect('fromstock', [
                'idelement' => $modelitem->idelements,
                    ]);
        }else{
            return $this->redirect('fromstock', [
               'modelitem' => $modelitem,
               'model' => $model,
            ]);
        }
     
    }
    
    
    protected function findModel($id)
    {
        if (($model = Elements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
