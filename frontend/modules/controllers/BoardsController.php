<?php
namespace frontend\modules\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\filters\AccessControl;

use common\models\Outofstock;
use backend\models\OutofstockSearch;
use common\models\Boards;
use backend\models\BoardsSearch;
use common\models\Themes;
use common\models\Themeunits;



class BoardsController extends Controller
{
   public function behaviors()
    {
         return [
            'access' => [
                'class' => AccessControl::className(),
              //  'only' => ['index', 'view','create'],
                'rules' => [
                    [
                      //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
                        'actions' => ['create', 'myboards', 'update', 'view', 'currentboard'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view', 'currentboard', 'myboards', 'create'],
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
        $searchModel = new BoardsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionMyboards($iduser)
    {
        $searchModel = new BoardsSearch();
        $model = new Boards();
        $model->current = $iduser;
        
        $query = Boards::find()->where(['current' => $iduser])->andWhere(['discontinued' => '1'])->orderBy('date_added DESC')->orderBy('discontinued ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('myboards', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        $searchModeloutof = new OutofstockSearch();
        $queryoutof = Outofstock::find()->where(['idboart' => $id]);
        $dataProvideroutof = new ActiveDataProvider([
            'query' => $queryoutof,
            'pagination' =>['pageSize' => 50],
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvideroutof' => $dataProvideroutof,
            'searchModeloutof' => $searchModeloutof,
        ]);
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
    
    public function actionCurrentboard()
    {
        $searchModel = new BoardsSearch();
        
        $query = Boards::find()->where(['discontinued' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('currentboard', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = Boards::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
