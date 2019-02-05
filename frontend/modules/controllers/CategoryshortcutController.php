<?php

namespace frontend\modules\controllers;

use Yii;
use common\models\Categoryshortcut;
use backend\models\CategoryshortcutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use common\models\Projectshortcut;
use backend\models\ProjectshortcutSearch;

/**
 * CategoryshortcutController implements the CRUD actions for Categoryshortcut model.
 */
class CategoryshortcutController extends Controller
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
     * Lists all Categoryshortcut models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoryshortcutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      /*  $query = Categoryshortcut::find()->where(['parent_id' => FALSE]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);*/
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoryshortcut model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewbycategory($id)
    {
        $model = new Projectshortcut();
        $modelcategory = new Categoryshortcut;
        $searchModel = new ProjectshortcutSearch();
        
        $query = Projectshortcut::find()->with('categoryshortcut')->where(['category' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
        
        return $this->render('viewbycategory', [
            'searchModel' =>$searchModel,
            'dataProvider' =>$dataProvider,
            'model' =>$model,
            'modelcategory' => $modelcategory,
        ]);
    }

    /**
     * Creates a new Categoryshortcut model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categoryshortcut();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categoryshortcut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Categoryshortcut model.
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
     * Finds the Categoryshortcut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categoryshortcut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categoryshortcut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
