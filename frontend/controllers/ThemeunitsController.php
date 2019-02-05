<?php
namespace frontend\controllers;

use yii;
use common\models\Themeunits;
use backend\models\ThemeunitsSearch;
use \yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    
    protected function findModel($id)
    {
        if (($model = Boards::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
