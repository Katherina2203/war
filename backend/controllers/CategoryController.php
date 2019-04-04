<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

use common\models\Elements;
use backend\models\ElementsSearch;
use common\models\Prices;
use backend\models\PricesSearch;
use common\models\Outofstock;
use backend\models\OutofstockSearch;
use common\models\Produce;
use common\models\Categoryproduce;
/**
 * 
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Category();
        $searchModel = new CategorySearch();

    //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $queryParent = Category::find()->where(['parent' => FALSE])->groupBy('idcategory'); //->orderBy('idcategory DESC')
        //$pages = new Pagination(['totalCount' => $queryParent->count()]);
        
        $dataProviderParent = new ActiveDataProvider([
            'query'=> $queryParent//->offset($pages->offset)//->limit($pages->limit),
                        ]);
        
      /*  $dataProviderChild = new ActiveDataProvider([
                            'query'=> Category::find()->where("parent=:parent", [":parent"=>$model->idcategory])
                                    ->orderBy('name ASC') //, [":parent"=>$model->idcategory = 1]  ->groupBy('idcategory')
                        ]); */

        return $this->render('index', [
            'model' => $model,
          //  'pages' => $pages,
            'searchModel' => $searchModel,
            'dataProviderParent' => $dataProviderParent,
        //    'dataProviderChild' => $dataProviderChild,
        ]);
    }
    
    public function actionBymanufacturer()
    {
        $model = new Category();
        $searchModel = new CategorySearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query'=> Category::find()->where(['parent' => FALSE])
                        ]);

        $modelpr = new Produce();
        $dataProviderProduce = new ActiveDataProvider([
            'query'=> $modelpr->getCategory()->orderBy('manufacutre ASC'),// Produce::find()//->where("parent=:parent", [":parent"=>$model->idcategory]) //, [":parent"=>$model->idcategory = 1]
        ]); 
        
        return $this->render('bymanufacturer', [
            'model' => $model,
            'modelpr' => $modelpr,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderProduce' => $dataProviderProduce,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Displays a Category with Produce list.
     * @param integer $id is idcategory 
     * @return mixed
     */
    
    public function actionViewcategoryproduce($id)
    {
        $modelcp = new Categoryproduce();
        
        $dataProvider = new ActiveDataProvider([
            'query'=>Categoryproduce::find()->where(['idcategory' => $id]) //$modelcp->getProduce(), //->where(['idcategory' => $id])
        ]); 
        
         
        return $this->render('viewcategoryproduce', [
            'model' => $this->findModel($id),
            'modelcp' => $modelcp,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcategory]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreatemanufacture()
    {
        $model = new \common\models\Categoryproduce();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewcategoryproduce', 'id' => $model->idcategory]);
        } else {
            return $this->render('createmanufacture', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreatecategmanufacture($id) 
    {
        $model = new \common\models\Categoryproduce();
        $model->idcategory = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewcategoryproduce', 'id' => $model->idcategory]);
        } else {
            return $this->render('createmanufacture', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcategory]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionItems($id)
    {
        $model = new Elements();
        $searchModel = new ElementsSearch();
        
        $query = Elements::find()->with('produce')->where(['idcategory' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        
        return $this->render('items',[
            'searchModel' =>$searchModel,
            'dataProvider' =>$dataProvider,
            'model' =>$model,
        ]);
    }
    
    public function actionViewprice($idel)
    {
       
        $model = new Prices;
        $searchModel = new PricesSearch;
        
              
        $query = Prices::find()->where(['idel' => $idel]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('viewprice', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionFromstock($idel)
    {
        $modelout = new Outofstock();
        $searchModelout = new OutofstockSearch();
        
        $query = Outofstock::find()->where(['idelement' => $idel]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('fromstock',[
            'model' => $modelout,
            'searchModel' => $searchModelout,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
