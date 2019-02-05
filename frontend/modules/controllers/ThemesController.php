<?php
namespace frontend\modules\controllers;

use Yii;
use common\models\Themes;
use backend\models\ThemesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

use \common\models\Themeunits;
use backend\models\ThemeunitsSearch;
use common\models\Boards;
use backend\models\BoardsSearch;
use common\models\Outofstock;
use backend\models\OutofstockSearch;

class ThemesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['admin', 'manager', 'head'],
                ],
                [
                    'actions' => ['indexshort'],
                    'allow' => true,
                   // 'roles' => ['admin', 'manager', 'head'],
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
        $searchModel = new ThemesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndexshort()
    {
        $model = new Themes();
        $searchModel = new Themes();
        
        $query = Themes::find()->where(['status' => 'active'])->orderBy('created_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('indexshort',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUnits($id)
    {
       // $model = new Themes();
     //   $searchModel = new ThemesSearch();
        
        $modelunits = new Themeunits();
        $searchModelUnits = new ThemeunitsSearch();
        
        $query = Themeunits::find()->where(['idtheme' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('units',[
        //    'model' => $model,
            'modelunits' => $modelunits,
         //   'searchModel' => $searchModel,
            'searchModelUnits' => $searchModelUnits,
            'dataProvider' => $dataProvider,
            ]
        );
    }
    
    public function actionBoards($id)
    {
        $model = new Boards();
        $searchModel = new BoardsSearch();
        
        $query = Boards::find()->where(['idtheme' => $id, 'discontinued' => '1'])->orderBy('date_added DESC');
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
          return $this->render('boards',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]
        );
         
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewitems($id)
    {
        $model = new Outofstock();
        $searchModel = new OutofstockSearch();
        
        $query = Outofstock::find()->where(['idboart' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
          return $this->render('viewitems',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]
        );
    }
    
     public function actionQuicklist($idboards, $idtheme, $idthemeunit)
    {
        $model = new Outofstock();
        $searchModelout = new OutofstockSearch();
        
        $query = Outofstock::find()->where(['idboart' => $idboards, 'idtheme' => $idtheme, 'idthemeunit' => $idthemeunit]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('quicklist', [
             'model' => $model,
             'searchModel' => $searchModelout,
             'dataProvider' => $dataProvider,
             ]);
    }
    
     protected function findModel($id)
    {
        if (($model = Themes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
