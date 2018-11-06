<?php
namespace frontend\modules\controllers;

use Yii;
use common\models\Themeunits;
use backend\models\ThemeunitsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Boards;
use backend\models\BoardsSearch;

class ThemeunitsController extends Controller
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
        $searchModel = new ThemeunitsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionBoards($idunit)
    {
        $modelboards = new Boards();
        $searchModelboards = new BoardsSearch();
        
        $query = Boards::find()->where(['idthemeunit' => $idunit]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('boards', [
            'model' => $modelboards,
            'serchModel' => $searchModelboards,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = Themeunits::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
