<?php
namespace frontend\modules\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Category;
use backend\models\CategorySearch;
use common\models\Elements;
use backend\models\ElementsSearch;
use common\models\Prices;
use backend\models\PricesSearch;
use common\models\Outofstock;
use backend\models\OutofstockSearch;


class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
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
        $model = new Category();
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $dataProviderParent = new ActiveDataProvider([
            'query'=> Category::find()->where(['parent' => FALSE])//->orderBy('idcategory DESC')
                        ]);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderParent' => $dataProviderParent,
         //   'dataProviderChild' => $dataProviderChild,
        ]);
    }
    
    public function actionItems($id)
    {
        $model = new Elements();
        $searchModel = new ElementsSearch();
        
        $query = Elements::find()->where(['idcategory' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
        return $this->render('items',[
            'searchModel' =>$searchModel,
            'dataProvider' =>$dataProvider,
            'model' =>$model,
        ]);
    }
    
    public function actionViewprice($idel)
    {
       
        $model = new Prices;
        $searchModel = new PricesSearch;
        
              
        $query = Prices::find()->where(['idel' => $idel]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('viewprice', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionFromstock($idel)
    {
        $modelout = new Outofstock();
        $searchModelout = new OutofstockSearch();
        
        $query = Outofstock::find()->where(['idelement' => $idel]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('fromstock',[
            'model' => $modelout,
            'searchModel' => $searchModelout,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
