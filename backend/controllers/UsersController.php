<?php

namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

use common\models\Users;
use backend\models\UsersSearch;


/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                  'class' => AccessControl::className(),
                 // 'only' => ['index', 'department', 'myprofile'],
                  'rules' => [
                      [
                          'actions' => ['index','myprofile', 'view'],
                          'allow' => true,
                          'roles' => ['@'],
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Users();
        $searchModel = new UsersSearch();
        
     /*   $query = Users::find()->where(['status' => 10])->all();//->where(['status' => 10])
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/
        $query = Users::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            
        ]);
    }

    public function actionDepartment()
    {
        $model = new Users();
        $searchModel = new UsersSearch();
        
        $query = Users::find()->where(['status' => 10]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('department', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/users/';

        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'photo');
            $model->photo = $photo->name;
            $ext = end((explode(".", $photo->name)));
            
            $path = Yii::$app->params['uploadPath'] . $model->photo;
            if($model->save()){
            $photo->saveAs($path);
            Yii::$app->session->setFlash('success', 'Image uploaded successfully');
            return $this->redirect(['view', 'id'=>$model->id]);

        } else {
            Yii::$app->session->setFlash('error', 'Fail to save image');
        }
         return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/users/';

        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'photo');
            $model->photo = $photo->name;
            $ext = end((explode(".", $photo->name)));
            
            $path = Yii::$app->params['uploadPath'] . $model->photo;
            if($model->save()){
            $photo->saveAs($path);
            Yii::$app->session->setFlash('success', 'Image uploaded successfully');
            return $this->redirect(['view', 'id'=>$model->id]);

        } else {
            Yii::$app->session->setFlash('error', 'Fail to save image');
        }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'searchModeluser' => $searchModeluser,
            ]);
        }
    }

     public function actionMyprofile($id)
    {
       
         return $this->render('myprofile', [
            'model' => $this->findModel($id),
         
        ]);
        
    }
    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
