<?php

namespace backend\controllers;

use Yii;

use backend\models\ThemesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

use common\models\Themes;
use common\models\Themeunits;
use backend\models\ThemeunitsSearch;
use common\models\Boards;
use backend\models\BoardsSearch;
use common\models\Outofstock;
use backend\models\OutofstockSearch;
use common\models\Prices;
use backend\models\PricesSearch;
use common\models\Elements;
use backend\models\ElementsSearch;
use backend\models\RequestsSearch;
use common\models\Requests;

/**
 * ThemesController implements the CRUD actions for Themes model.
 */
class ThemesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
              //  'only' => ['create', 'update'],
                'rules' => [
                     [
                      //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
                        'actions' => ['createboard', 'create', 'update', 'units', 'boards', 'index', 'indexshort'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'untis', 'boards', 'indexshort'],
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

    /**
     * Lists all Themes models.
     * @return mixed
     */
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
        
        $query = Themes::find()->where(['status' => 'active']);//->orderBy('created_at DESC')
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('indexshort',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUnits($idtheme)
    {
        $modelunits = new Themeunits();
        $searchModelUnits = new ThemeunitsSearch();
        
        $modelreq = new Requests();
        $searchModelreq = new RequestsSearch();
        
        $query = Themeunits::find()->where(['idtheme' => $idtheme]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $queryreq = Requests::find()->where(['idproject' => $idtheme])->orderBy(['created_at DESC'])->orderBy('status ASC')->limit(20);
        $dataProviderreq = new ActiveDataProvider([
            'query' => $queryreq,
            
        ]);
        
        return $this->render('units',[
            'modelreq' => $modelreq,
            'model' => $this->findModel($idtheme),
            'modelunits' => $modelunits,
            'searchModelreq' => $searchModelreq,
            'searchModelUnits' => $searchModelUnits,
            'dataProvider' => $dataProvider,
            'dataProviderreq' => $dataProviderreq
            ]
        );
    }
    
    public function actionBoards($idtheme, $idthemeunit)
    {
        $model = new Boards();
        $model->idtheme = $idtheme;
      //  $modelth = Themes::findOne($idtheme);
        $model->idthemeunit = $idthemeunit;
        $searchModel = new BoardsSearch();
         
        $query = Boards::find()->with(['users'])->where(['idtheme' => $idtheme])->andWhere(['idthemeunit' => $idthemeunit])->orderBy('date_added DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
        return $this->render('boards',[
            'model' => $model,
            'searchModel' => $searchModel,
            'modelth' => $this->findModel($idtheme),
          //  'dataProvideroutof' => $dataProvideroutof,
          //  'searchModeloutof' => $searchModeloutof,
            'dataProvider' => $dataProvider,
           
            ]
        );
    }
    
    public function actionBoardscost($id)
    {
        $model = new Boards();
        $searchModel = new BoardsSearch();
        
        $modelprice = new Prices();
        $searchModelprice = new PricesSearch();
        
        $query = Boards::find()->where(['idtheme' => $id]);
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
          return $this->render('boards',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelprice' => $modelprice,
            'searchModelprice' => $searchModelprice,
            ]
        );
    }
    
    public function actionViewitems($id)
    {
        $searchModeloutof = new OutofstockSearch();
        $searchModelelem = new ElementsSearch();
        
        $modelelem = new Elements();
        
        $model = new Outofstock();
        // $searchModel = new OutofstockSearch();
        $modelboard = new Boards();
        
        $queryoutof = Outofstock::find()->with(['elements', 'users'])->where(['idboart' => $id]);
        $dataProvideroutof = new ActiveDataProvider([
            'query' => $queryoutof,
            'pagination' =>['pageSize' => 50],
        ]);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->idtheme;
            $model->idthemeunit;
            $model->idboart = $id;
            
            $model->save();
            return $this->redirect(['view', 
                'id' => $model->idboart,
                'model' => $model,
                'modelboard' => $modelboard,
                'searchModeloutof' => $searchModeloutof,
                'dataProvideroutof' => $dataProvideroutof,
                'searchModelelem' => $searchModelelem,
                'modelelem' => $modelelem,
                    
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
      /*  return $this->render('viewitems',[
            'model' => $model,
            'searchModeloutof' => $searchModeloutof,
            'dataProvideroutof' => $dataProvideroutof,
            'searchModelelem' => $searchModelelem,
            'modelelem' => $modelelem,
            ]
        );*/
    }

    /**
     * Displays a single Themes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Themes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Themes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idtheme]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateboard($idtheme, $idthemeunit)
    {
      //  $model = new Themes();
        $model = new Boards();
        $model->idtheme = $idtheme;
        $model->idthemeunit = $idthemeunit;
        $model->discontinued = 1;

        if ($model->load(Yii::$app->request->post())) {
        //    $model->idtheme = $idtheme;
          //  $model->idthemeunit = $idthemeunit;
          //  $model->discontinued = 1;
             
            if($model->save(false)){
                Yii::$app->session->setFlash('success', 'Плата успешно добавлена! Номер платы ' . $model->idtheme . '-' . $model->idthemeunit . '-' . $model->idboards);
            //    return $this->redirect(['boards',  'idthemeunit' => $model->idthemeunit]);             //['idtheme' => $model->idtheme,  
                return $this->redirect(['boards', 'idtheme' => $model->idtheme, 'idthemeunit' => $model->idthemeunit]);
            }else{
                 Yii::$app->session->setFlash('error', 'Плата не былa созданa!');
            }
            
        } else {
            return $this->render('createboard', [
                'model' => $model,
              //  'modelboard' => $modelboard,
            ]);
        }
    }
    
  /*  public function actionCreatebytheme($idtheme)
    {
        $model = new Themeunits();
        $model->idtheme = $idtheme;
       // $model = $this->findModel($idtheme);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['view', 'idtheme' => $model->idtheme]);
        } else {
            return $this->render('createbytheme', [
               // 'model' => $model,
                'model' => $this->findModel($idtheme),
            ]);
        }
    }
   * */


    /**
     * Updates an existing Themes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idtheme]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Themes model.
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
     * Finds the Themes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Themes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Themes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
