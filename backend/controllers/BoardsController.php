<?php

namespace backend\controllers;

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
use common\models\Shortage;
use common\models\Requests;
use backend\models\RequestsSearch;
use common\models\Specification;
use backend\models\SpecificationSearch;

use common\models\BoardsQuery;
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
        $query = Boards::find()->groupBy(['idtheme', 'idthemeunit'])->orderBy('created_at DESC'); //->orderBy('discontinued ASC')
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRequests($idb)
    {
        $model = $this->findModel($idb);
        $modelrequests = new Requests();
        $searchModel = new RequestsSearch();
        
        $query = Requests::find()->where(['idboard' => $idb])->orderBy('created_at DESC');
        $dataProviderreq = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('requests', [
            'model' => $model,
            'modelrequests' => $modelrequests,
            'dataProviderreq' => $dataProviderreq,
            'searchModel' => $searchModel,
        ]);
    }
    
    public function actionCurrentboard()
    {
        $searchModel = new BoardsSearch();
      
       
        
        $query = Boards::find()->active()->groupBy(['idtheme', 'idthemeunit']);
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
        $model = $this->findModel($id);
        $searchModeloutof = new OutofstockSearch();
        $searchModelelem = new ElementsSearch();
        
     //   $modelelem = new Elements();
        $modelspec = new Specification();
        
        $queryoutof = Outofstock::find()->with(['elements', 'users'])->where(['idboart' => $id]);
        $dataProvideroutof = new ActiveDataProvider([
            'query' => $queryoutof,
            'pagination' =>['pageSize' => 50],
        ]);
        
        $searchModelspec = new SpecificationSearch();
        $queryspec = Specification::find()->with(['elements'])->where(['idboard' => $id]);
        $dataProviderspec = new ActiveDataProvider([
            'query' => $queryspec,
            'pagination' =>['pageSize' => 50],
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'dataProvideroutof' => $dataProvideroutof,
            'dataProviderspec' => $dataProviderspec,
            'searchModeloutof' => $searchModeloutof,
            'searchModelelem' => $searchModelelem,
            'searchModelspec' =>$searchModelspec,
            'modelspec' => $modelspec,
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
    public function actionShortage($idboard) 
    {
        $model = $this->findModel($idboard);
        $modelsh = new Shortage();
        $searchModelsh = new \backend\models\ShortageSearch();
        
        $query = Shortage::find()->where(['idboard' => $idboard]);
        $dataProvidersh = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        
          return $this->render('shortage', [
               'model' => $model,
               'modelsh' => $modelsh,
               'searchModelsh' => $searchModelsh,
               'dataProvidersh' => $dataProvidersh,
             ]);
        
    }
    
    public function actionOutof($idboard)
    {
        $model = $this->findModel($idboard);
         
        $queryoutof = Outofstock::find()->with(['elements', 'users'])->where(['idboart' => $idboard]);
        $dataProvideroutof = new ActiveDataProvider([
            'query' => $queryoutof,
            'pagination' =>['pageSize' => 50],
        ]);
        
         return $this->render('shortage', [
               'model' => $model,
            
              
               'dataProvideroutof' => $dataProvideroutof,
             ]);
        
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
