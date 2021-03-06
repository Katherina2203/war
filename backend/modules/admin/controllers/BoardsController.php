<?php

namespace app\modules\admin\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

use common\models\Outofstock;
use backend\models\OutofstockSearch;
use common\models\Boards;
use backend\models\BoardsSearch;
use common\models\Themes;
use common\models\Themeunits;
use common\models\Elements;
use backend\models\ElementsSearch;


/**
 * BoardsController implements the CRUD actions for Boards model.
 */
class BoardsController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Boards models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoardsSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = Boards::find()->where(['discontinued' => 1])->groupBy(['idtheme', 'idthemeunit']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCurrentboard()
    {
        $searchModel = new BoardsSearch();
      
       
        
        $query = Boards::find()->where(['discontinued' => 1])->groupBy(['idtheme', 'idthemeunit']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('currentboard', [
            'searchModel' => $searchModel,
          
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single Boards model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModeloutof = new OutofstockSearch();
        $searchModelelem = new ElementsSearch();
        
        $modelelem = new Elements();
        
        $queryoutof = Outofstock::find()->with(['elements', 'users'])->where(['idboart' => $id]);
        $dataProvideroutof = new ActiveDataProvider([
            'query' => $queryoutof,
            'pagination' =>['pageSize' => 50],
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvideroutof' => $dataProvideroutof,
            'searchModeloutof' => $searchModeloutof,
            'searchModelelem' => $searchModelelem,
            'modelelem' => $modelelem,
        ]);
    }

    /**
     * Creates a new Boards model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Boards();
        $model->discontinued = '1';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idboards]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Boards model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idboards]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionQuicklist($iduser, $idboards, $idtheme, $idthemeunit)
    {
        $model = new Outofstock();
        $searchModelout = new OutofstockSearch();
        $model->iduser = $iduser;
        
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
    
     public function actionThemeunit() 
    {
        $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $idtheme = $parents[0];
            $out = Themeunits::getThemeunitsList($idtheme); 
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    /**
     * Deletes an existing Boards model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Boards model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Boards the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Boards::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
