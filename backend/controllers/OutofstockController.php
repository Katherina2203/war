<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\db\Transaction;
use yii\db\Expression;


use common\models\Outofstock;
use backend\models\OutofstockSearch;
use common\models\Users;
use backend\models\UsersSearch;
use common\models\Themeunits;
use common\models\Boards;
use common\models\Elements;
/**
 * OutofstockController implements the CRUD actions for Outofstock model.
 */
class OutofstockController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
         //   'access' => [
           //     'class' => \yii\filters\AccessControl::className(),
              /*  'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                ],*/
          //  ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Outofstock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OutofstockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Outofstock model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      //  $model = new Outofstock();
     //   $model->idelement = $idel;
        $searchModel = new OutofstockSearch();
        
        $query = Outofstock::find()->orderBy('date DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
     
        ]);
    }
 
    /**
     * Creates a new Outofstock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  /*  public function actionCreate($iduser)
    {
        $model = new Outofstock();
        $modeluser = new Users();
        $model->iduser = $iduser;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idofstock]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modeluser' => $modeluser,
            ]);
        }
    }*/
     public function actionCreate($iduser)
    {
        $model = new Outofstock();
        $modelelements = new Elements();
        $quantity = $modelelements->quantity;
        $modeluser = new Users();
        $model->iduser = $iduser;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = $model->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(
                 //   Transaction::SERIALIZABLE
                    );
            try{

                $valid = $model->validate();
               //  Yii::$app->db->createCommand()->update('elements', ['quantity' => $quantity],['idelements' => $model->idelement])->execute();
               
           /*     if($quantity){
                  $quantity = $quantity - $model->quantity;
                 
                  Yii::$app->session->setFlash('success', 'Количество успешно вычтено');
                 
                  
                    
                }else{
                    Yii::$app->session->setFlash('error', 'Количество со склада не было вычтено');

                }*/
                Yii::$app->db->createCommand()->update('elements', ['quantity' => new Expression('quantity - :modelquantity', [':modelquantity' => $model->quantity])], ['idelements'=> $model->idelement])->execute();
               
               
                
                if ($valid) {
                // the model was validated, no need to validate it once more
                    $model->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Товар успешно взят со склада');
                    return $this->redirect(['view', 'id' => $model->idofstock]);  
                } else {
                    $transaction->rollBack();
                }  
            }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
           
        } else {
            return $this->render('create', [
                'model' => $model,
                'modeluser' => $modeluser,
                'modelelements' => $modelelements,
            ]);
        }
          
    }
 
    /**
     * Updates an existing Outofstock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $idelement)
    {
        $model = $this->findModel($id, $idelement);
        $model->idelement = $idelement;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idofstock, 'idelement' => $model->idelement]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Outofstock model.
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
     * Finds the Outofstock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Outofstock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionQuickcompl($iduser)
    {
        $model = new Outofstock();
        
   //     $searchModel = new OutofstockSearch();
        
        $query = Outofstock::find()->where(['iduser' => '4', 'idtheme' => '36', 'idthemeunit' => '10', 'idboart' => '210']);
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
                
        return $this->redirect('quickcompl', [
            'model' => $model,
           // 'searchModel' => $searchModel,
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
                if (isset($_POST['depdrop_all_params'])) {
                    foreach ($_POST['depdrop_all_params'] as $key => $value) {
                        // $key = Element ID 
                        // $value = Element Value
                    }
                }
            }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
 
    public function actionBoard() 
    {
        $post = Yii::$app->request->post('depdrop_parents');
//        $out = [];
        if (isset($post)) {
            //$idtheme = empty($ids[0]) ? null : $ids[0];
            $idthemeunit = empty($post[0]) ? null : $post[0];
            if (!is_null($idthemeunit)) {
//                $data = Boards::getBoardList($idthemeunit);
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'output'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */

                echo Json::encode(Boards::getBoardList($idthemeunit));
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    
    }
   
  
    /**
     * Updates an existing Planificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    
    
    protected function findModel($id)
    {
        if (($model = Outofstock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
