<?php

namespace backend\controllers;

use Yii;
use common\models\Themeunits;
use backend\models\ThemeunitsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Boards;
use backend\models\BoardsSearch;
use common\models\Themes;
/**
 * ThemeunitsController implements the CRUD actions for Themeunits model.
 */
class ThemeunitsController extends Controller
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
     * Lists all Themeunits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThemeunitsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Themeunits model.
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
    
    /**
     * Creates a new Themeunits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Themeunits();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idunit]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreatebytheme($idtheme)
    {
        $model = new Themeunits();
        $model->idtheme = $idtheme;
        //$modeltheme = new Themes();

        if ($model->load(Yii::$app->request->post())) {
           $model->idtheme = $idtheme;
            
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Модуль успешно добавлен в проект!');
                return $this->redirect(['themes/units', 'idtheme' => $model->idtheme]);
            }else{
                 Yii::$app->session->setFlash('error', 'Модуль не был создан!');
            }
        } else {
            return $this->render('createbytheme', [
             //   'model' => $this->findModel($idtheme),
                'model' => $model,
             ]);
        }
    }

    /**
     * Updates an existing Themeunits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idunit]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Themeunits model.
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
     * Finds the Themeunits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Themeunits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Themeunits::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
