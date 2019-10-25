<?php
namespace frontend\modules\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\web\HttpException;
use yii\helpers\Html;
use yii\db\Expression;
use yii\filters\AccessControl;


use common\models\Elements;
use backend\models\ElementsSearch;
use common\models\Prices;
use backend\models\PricesSearch;
use common\models\Outofstock;
use backend\models\OutofstockSearch;
use common\models\Receipt;
use backend\models\ReceiptSearch;
use common\models\Requests;
use backend\models\RequestsSearch;
use common\models\Accounts;
use backend\models\AccountsSearch;
use common\models\Users;
use common\models\Returnitem;
use common\models\Purchaseorder;
use common\models\Produce;
use common\models\Shortage;
use common\models\Boards;
use common\models\Specification;
use common\models\AccountsRequests;
use common\models\RequestStatusHistory;
use common\models\Category;
/**
 * ElementsController implements the CRUD actions for Elements model.
 */
class ElementsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['create', 'update'],
                'rules' => [
                   [
                       'allow' => true,
                     //  'roles' => ['admin', 'Purchasegroup'],//, 'Purchasegroup'
                   ] 
                ]
                
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
     * Lists all Elements models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ElementsSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel->search(Yii::$app->request->queryParams),
            'sort' => [
                'attributes' => [
                    'idelements' => [
                        'asc' => ['e.idelements' => SORT_ASC],
                        'desc' => ['e.idelements'=> SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                    'box' => [
                        'asc' => ['e.box' => SORT_ASC],
                        'desc' => ['e.box'=> SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['e.name' => SORT_ASC],
                        'desc' => ['e.name'=> SORT_DESC],
                    ],
                    'nominal' => [
                        'asc' => ['e.nominal' => SORT_ASC],
                        'desc' => ['e.nominal'=> SORT_DESC],
                    ],
                    'quantity' => [
                        'asc' => ['e.quantity' => SORT_ASC],
                        'desc' => ['e.quantity'=> SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                    'category_name' => [
                        'asc' => ['category_name' => SORT_ASC],
                        'desc' => ['category_name'=> SORT_DESC],
                    ],
                    'manufacture' => [
                        'asc' => ['manufacture' => SORT_ASC],
                        'desc' => ['manufacture'=> SORT_DESC],
                    ],
                    'active' => [
                        'asc' => ['e.active' => SORT_ASC],
                        'desc' => ['e.active'=> SORT_DESC],
                    ],
                ],
            ]
        ]);
        
        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'aCategoryHierarchy' => Category::getHierarchy(),
                'aProduce' => ArrayHelper::map(Produce::find()->select(['idpr', 'manufacture',])->orderBy('manufacture ASC')->asArray()->all(), 'idpr', 'manufacture'),
            ]);
    }
    /**
     * Displays a single Elements model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       //  $model = new Elements();
        $model = Elements::findOne($id);
       //show prices
        $modelprice = new Prices();
        $searchModel2 = new PricesSearch();
        
        $query = Prices::find()->where(['idel' => $id])->orderBy('created_at DESC')->limit(10);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $query,
        ]);
        //end show prices
        
        //view specification
        
        $receipt = new Receipt();
        
        $modelSpecification = new Specification();
        $querySpecification = Specification::find()->where(['idelement' => $id])->andWhere(['status' => '1'])->orderBy('created_at DESC'); //show where need element
        $dataProviderSpecification = new ActiveDataProvider([
            'query' => $querySpecification,
        ]);
        
        $queryacc = Accounts::find()->where(['idelem' => $id])->orderBy('date_receive DESC')->limit(10);
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
        
        
        $queryar = AccountsRequests::getAccountsRequestsDetails($id);
        $dataAccountsRequests = new ActiveDataProvider([
            'query' => $queryar,
        ]);
        
        $querypur = Purchaseorder::find()->where(['idelement' => $id])->orderBy('created_at DESC')->limit(5);
//        echo '<pre>'; var_dump($querypur->createCommand()->rawSql); echo '</pre>'; die();
        $dataProviderpur = new ActiveDataProvider([
            'query' => $querypur,
        ]);  /*in future point the limit of requests..E.x. last 5 orders */
        
        $searchModelout = new OutofstockSearch();
        $queryout = $searchModelout->search();
//        $queryout = Outofstock::find()->where(['idelement' => $id])->with(['themes', 'themeunits',])->orderBy('date DESC');//
        $dataProviderout = new ActiveDataProvider([
            'query' => $queryout,
        ]);
        
        $searchModelreceipt = new \backend\models\ReturnitemSearch();
        $queryreceipt = Returnitem::find()->where(['idelement' => $id])->orderBy('created_at DESC');
        $dataProviderreceipt = new ActiveDataProvider([
            'query' => $queryreceipt,
        ]);
        
        
        //requests
        $modelrequests = new Requests();
        $modelrequests->idtype = '1';
        $modelrequests->status = '0';
        $modelrequests->iduser = yii::$app->user->identity->id;
       // if(\yii::$app->request->isAjax && $modelrequests->load(\yii::$app->request->post())){      
        if ($modelrequests->load(\yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();
            
            $modelrequests->name = $model->name;
            $modelrequests->description = $model->nominal;
            $modelrequests->idproduce = $model->idproduce;
            $modelrequests->estimated_category = $model->idcategory;
            $modelrequests->estimated_idel = $model->idelements;

            try {
                if ($modelrequests->validate()) {
                    if ($modelrequests->idboard != NULL) {
                        //create shortage
                        Yii::$app->db->createCommand()->insert('specification', [
                            'idboard' => $modelrequests->idboard, 
                            'idelement' => $model->idelements, 
                            'quantity' => $modelrequests->quantity, 
                            'status' => Specification::STATUS_ACTIVE,
                            'created_by' => yii::$app->user->identity->id,
                            'updated_by' => yii::$app->user->identity->id,
                            ])->execute();
                    }

                
                    $modelrequests->save(false);
                    
                    $modelRequestStatusHistory = new RequestStatusHistory();
                    $modelRequestStatusHistory->idrequest = $modelrequests->idrequest;
                    $modelRequestStatusHistory->status = $modelrequests->status;
                    $modelRequestStatusHistory->note = $modelrequests->note;
                    $modelRequestStatusHistory->save(false);

                    $transaction->commit();
                    
                    Yii::$app->session->setFlash('success', 'Товар успешно отправлен в заявку!');
                    return $this->redirect(['elements/view', 'id' => $model->idelements]);
                } else {
                    Yii::$app->session->setFlash('error', 'Возникла ошибка при создании заявки');
                }
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch(\Throwable $e) {
                $transaction->rollBack();
            }
        }
        
        return $this->render('view', [
         //   'pages' => $pages,
            'model' => $this->findModel($id),
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'modelprice' => $modelprice,
            'modelrequests' => $modelrequests,
            'receipt' => $receipt,
            'modelSpecification' => $modelSpecification,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderpur' => $dataProviderpur,
            'dataProviderout' => $dataProviderout,
            'dataProviderSpecification' => $dataProviderSpecification,
            'searchModelout' => $searchModelout,
            'searchModelreceipt' => $searchModelreceipt,
            'dataProviderreceipt' => $dataProviderreceipt,
            'dataAccountsRequests' => $dataAccountsRequests,
        ]);
    }
    
    public function actionVieworder($id)
    {
        $model = new Elements();
       //show prices
        $model2 = new Prices();
        $searchModel2 = new PricesSearch();
        
        $querypur = Prices::find()->where(['idel' => $id])->orderBy('created_at DESC');
        $dataProvider2 = new ActiveDataProvider([
            'query' => $querypur,
        ]);
        //end show prices
        
        //requests
        $modelrequests = new Requests();
        
         $query = Prices::find()->where(['idel' => $id])->orderBy('created_at DESC');
        $dataProviderpur = new ActiveDataProvider([
            'query' => $query,
        ]);
        
            
        $queryacc = Accounts::find()->where(['idelem' => $id])->orderBy('date_receive DESC');
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
           
        return $this->render('vieworder', [
            'model' => $this->findModel($id),
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'dataProviderpur' => $dataProviderpur,
            'model2' => $model2,
            'modelrequests' => $modelrequests,
            'dataProvideracc' => $dataProvideracc,
        ]);
    }

    /**
     * Creates a new Elements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Elements();
        $model->active = '1';
        $model->quantity = '0';
        
        Yii::$app->params['uploadPath'] = \yii::$app->basePath . 'frontend/images/';
        //$dir = Yii::getAlias('@frontend/images/') ;
       if ($model->load(Yii::$app->request->post())) {
           
            $image = UploadedFile::getInstance($model, 'image');
            
            if ($image && $image->tempName) {
                $model->image = $image;
         
                if ($model->image && $model->validate(['image'])){
                    $dir = Yii::getAlias('@frontend/'). 'images/';
                    $imagePath = $model->image->baseName .  '.' . $model->image->extension;
                    $model->image->saveAs($dir .  $imagePath); //$model->img->extension
                    $model->image = 'images/' .  $imagePath;        //{$model->id}/{$model->media_file->name}
                } 
            }
        
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Товар успешно добавлен');
                return $this->redirect(['view', 'id' => $model->idelements]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        

       /* $model = new Elements();

        \yii::$app->params['uploadPath'] = Yii::$app->basePath . '/images/';
        
        if ($model->load(\yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model,'image');
            $ext = end((explode(".", $image->name)));
            $model->photo = time().$model->id.".{$ext}"; 
           // $image->saveAs(\yii::$app->basePath.'/web/images/');

            //$model->image= $image->name;
           // $path = Yii::$app->basePath.'/web/images/' . $model->image;  
            $path = Yii::$app->params['uploadPath'] . $model->image;
            if($model->save()){
            $image->saveAs($path);

            return $this->redirect(['view', 'id' => $model->idelements]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    }

    public function actionCreatefrom($idel, $iduser)
    {
        $model = new Outofstock();
        $model->idelement = $idel;
        $model->iduser = $iduser;
        $user = new Users();
        $user->id = $iduser;
        $element = new Elements();
        $element->idelements = $idel;
        
        $board = new Boards();
        $model->idtheme = $board->idtheme;
        $model->idthemeunit = $board->idthemeunit;
        
       // $modelprice = new Prices();
     //   $idprice = $modelprice->idpr;
       // $lastprice = Prices::find()->orderBy(['idpr' => SORT_DESC])->where(['idel' => $model->idelement])->one();
      //  $model->idprice = $lastprice;
        


        if ($model->load(Yii::$app->request->post())) {
            
            $transaction = $model->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(
                 //   Transaction::SERIALIZABLE
                    );
            try{
                $valid = $model->validate();
               
                Yii::$app->db->createCommand()->update('elements', ['quantity' => new Expression('quantity - :modelquantity', [':modelquantity' => $model->quantity])], ['idelements'=> $model->idelement])->execute();

                if ($valid) {
                // the model was validated, no need to validate it once more
                    $model->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Товар успешно взят со склада');
                    return $this->redirect(['viewfrom', 'idel' => $model->idelement]);
                } else {
                    $transaction->rollBack();
                }  
                }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
           
        }
        return $this->render('createfrom', [
            'model' => $model,
            'user' => $user,
            'element' => $element,

        ]);
    }
    
     public function actionCreatereceipt($idord, $idel)
    {
        $model = new Receipt();
        $modelacc = new Accounts();
        $model->id = $modelacc->idelem = $idel;
        //$modelacc->idelem = $idel;
        $model->idinvoice = $idord;
        // $modelacc->status = '3';
       // $modelel = new Elements();
        if ($model->load(Yii::$app->request->post())) {
            
        $transaction = $model->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(
                 //   Transaction::SERIALIZABLE
                    );
        try{
            $valid = $model->validate();
                
                Yii::$app->db->createCommand()->update('accounts', ['status' => Accounts::ACCOUNTS_ONSTOCK],['idord' => $model->idinvoice])->execute();
                Yii::$app->db->createCommand()->update('elements', ['quantity' => new Expression('quantity + :modelquantity', [':modelquantity' => $model->quantity])],['idelements' => $model->id])->execute();
                Yii::$app->db->createCommand()->update('requests', ['status' => Requests::REQUEST_DONE], ['idrequest' => $model->requests->idrequest])->execute();
                
                if ($valid) {
                // the model was validated, no need to validate it once more
                    $model->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Товар успешно принят на склад!');
                    return $this->redirect(['elements/view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }  
                }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
            }else{
                return $this->render('createreceipt', [
                'model' => $model,
                'modelacc' => $modelacc,
              //  'modelel' => $modelel,
            ]);
            }
  
    }
    
    public function actionCreatequick()
    {
        $model = new Requests();
        $modelel = new Elements();

     //   if($modelel->active = 1){
             if ($model->load(Yii::$app->request->post()) && $modelel->load(Yii::$app->request->post())) {
            $modelel->name = $model->name;
            $modelel->nominal = $model->description;
            $modelel->idproduce = $model->idproduce;
            
            $model->save();
            return $this->redirect(['view', 'id' => $model->idelements]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
      //  }else{
      //       throw new NotFoundHttpException('Данная позиция устарела. Поищите аналог.');
      //  }
       
    }
    
    public function actionReceipt($idel, $idord)
    {
        $modelrec = new Receipt();
        $searchModelrec = new ReceiptSearch();

        $queryrec = Receipt::find()->where(['id' => $idel, 'idinvoice' => $idord]);
        $dataProviderrec = new ActiveDataProvider([
            'query' => $queryrec,
        ]);

        return $this->render('receipt', [
            'modelrec' => $modelrec,
            'dataProviderrec' => $dataProviderrec,
            'searchModelrec' => $searchModelrec,
        ]);
        
    }

    /**
     * Updates an existing Elements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/';
         
        if ($model->load(Yii::$app->request->post())) {
            
            $image = UploadedFile::getInstance($model, 'image');
            
           if ($image && $image->tempName) {
                $model->image = $image;

                if ($model->image && $model->validate(['image'])){
                    $dir = Yii::getAlias('@frontend/images/');
                    $imagePath = $model->image->baseName .  '.' . $model->image->extension;
                     $model->image->saveAs($dir .  $imagePath);
                  //  $model->image =  '.' . $model->image->extension;
                    $model->image = 'images/' .  $imagePath;   
                    //{$model->id}/{$model->media_file->name}
                    Yii::$app->session->setFlash('success', 'Image updated successfully');
                }
            }
            
          //  return $this->redirect(['view', 'id'=>$model->idelements]);
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Товар успешно изменен');
                return $this->redirect(['view', 'id' => $model->idelements]);
            }
       
           // return $this->redirect(['view', 'id' => $model->idelements]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Elements model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    
    public function actionViewprice($idel)
    {
        $model = new Prices();
        $searchModel = new PricesSearch();
        $model->idel = $idel;
        
        $query = Prices::find()->where(['idel' => $idel])->orderBy('created_at DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $modelEl = new Elements();
        $searchModelEl = new \frontend\models\elementsSearch();
        
        return $this->render('viewprice', [
            'model' => $model,
            'modelEl' => $modelEl,
            'searchModel' => $searchModel,
            'searchModelEl' => $searchModelEl,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionViewfrom($idel)
    {
        $element = Elements::findOne($idel);
        $model = new Outofstock();
        $searchModel = new OutofstockSearch();
        
        $query = Outofstock::find()->where(['idelement' => $idel])->with(['themes', 'themeunits', 'users', 'boards'])->orderBy('date DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $queryret = Returnitem::find()->where(['idelement' => $idel])->orderBy('created_at DESC');
        $dataProviderret = new ActiveDataProvider([
            'query' => $queryret,
        ]);
        
             
        return $this->render('viewfrom', [
            'model' => $model,
            'element' => $element,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderret' => $dataProviderret,
        ]);
    }
    
    public function actionTostock($idel)
    {
        $modelacc = new Accounts();
        $searchModelacc = new AccountsSearch();
        
        $query = Accounts::find()->where(['idelem' => $idel]);
        $dataProvideracc = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('tostock', [
            'modelacc' => $modelacc,
            'searchModelacc' => $searchModelacc,
            'dataProvideracc' => $dataProvideracc,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = Elements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
