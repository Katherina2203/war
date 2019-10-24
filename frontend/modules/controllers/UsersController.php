<?php
namespace frontend\modules\controllers;

use Yii;
use common\models\Users;
use backend\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;

class UsersController extends Controller
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
    
     public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
   
    
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
    
    public function actionMyprofile($id)
    {
        $modelout = new \common\models\Outofstock();
        $query = \common\models\Outofstock::find()->where(['iduser' => $id])->orderBy('date DESC');
        $dataProviderout = new ActiveDataProvider([
            'query'=>$query,
        ]);
        $searchModelout = new \backend\models\OutofstockSearch();
        
         return $this->render('myprofile', [
            'model' => $this->findModel($id),
            'modelout' => $modelout,
            'dataProviderout' => $dataProviderout,
            'searchModelout' => $searchModelout,
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
    
    public function actionChangePassword()
    {
        $user = \yii::$app->user->identity;
        $loadedPost = $user->load(\yii::$app->request->post());
        
        if($loadedPost && $user->validate){
            $user->password = $user->newPassword;
            $user->save(false);
            
            \yii::$app->session->setFlash('success', 'Вы успешно изменили пароль');
            return $this->refresh();
             
            
        }
        return $this->render('changePassword', [
            'user' => $user,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемой страницы не существует.');
        }
    }
}
