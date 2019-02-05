<?php
namespace app\modules\admin\controllers;

use Yii;
use common\modules\auth\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RbacController implements the CRUD actions for AuthItem model.
 */
class RbacController extends Controller
{
    public function behaviors()
    {
        $behaviors['access'] = [
             'class' => AccessControl::className(),
             'rules' => [
                 [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        
                        $module = Yii::$app->controller->module->id; 
                        $action = Yii::$app->controller->action->id;
                        $controller = Yii::$app->controller->id;
                        $route  = "$module/$controller/$action";
                        $post = Yii::$app->request->post();
                        if (\Yii::$app->user->can($route)) {
                             return true;
                        }
                        }
                 ],
             ],
           ];

 

        return $behaviors;
    }
    public function actionAssignment()
    {
        $auth = Yii::$app->authManager;
         
        $author = $auth->createRole('author');
        $admin = $auth->createRole('admin');
        
        
        $auth->assign($author, 2);
        $auth->assign($admin, 4);
    }
    
    public function actionCreate_rule()
    {
        $auth = Yii::$app->authManager;
         
        // add the rule
        $rule = new \common\modules\auth\rbac\AuthorRule;
        $auth->add($rule);

        // add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $auth->createPermission('UpdateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        $updatePost = $auth->createPermission('/adverts/update');
        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPost, $updatePost);

         $author = $auth->createPermission('author');
        // allow "author" to update their own posts
        $auth->addChild($author, $updateOwnPost); 
            }

        public function actionCreate_role()
    {
        $auth = Yii::$app->authManager;
        //Author->index/create/view
        //Admin->(Author)and update/delete -> index/create/view/update/delete
        //
        $index = $auth->createPermission('admin/rbac/index');
        $create = $auth->createPermission('admin/rbac/create');
        $view = $auth->createPermission('admin/rbac/view');
        $update = $auth->createPermission('admin/rbac/update');
        $delete = $auth->createPermission('admin/rbac/delete');        
        
        
        
         // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $index);
        $auth->addChild($author, $create);
        $auth->addChild($author, $view);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        
    }
    
  /*  public function actionCreate_rule()
    {
       $auth = Yii::$app->authManager;

       // add the rule
       $rule = new common\modules\auth\AuthorRule;
       $auth->add($rule);

       //add the "updateOwnPost" permission and associate the rule with it.
       $updateOwnPost = $auth->createPermission('updateOwnPost');
       $updateOwnPost->description = 'Update own post';
       $updateOwnPost->ruleName = $rule->name;
       $auth->add($updateOwnPost);
       
       $updatePost = $auth->createPermission('admin/rbac/update');
       // "updateOwnPost" will be used from "updatePost"
       $auth->addChild($updateOwnPost, $updatePost);

       $author = $auth->createPermission('author');
       // allow "author" to update their own posts
       $auth->addChild($author, $updateOwnPost); 
    }*/
    
    public function actionCreate_permission()
    {
        $auth = Yii::$app->authManager;

        // index
        $index = $auth->createPermission('admin/rbac/index');
        $index->description = 'Index rbac';
        $auth->add($index);

        // create
        $create = $auth->createPermission('admin/rbac/create');
        $create->description = 'Create rbac';
        $auth->add($create); 
        
        // view
        $view = $auth->createPermission('admin/rbac/view');
        $view->description = 'View rbac';
        $auth->add($view); 
        
        // update
        $update = $auth->createPermission('admin/rbac/update');
        $update->description = 'Update rbac';
        $auth->add($update); 
        
        // delete
        $delete = $auth->createPermission('admin/rbac/delete');
        $delete->description = 'Delete rbac';
        $auth->add($delete); 
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
       ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
