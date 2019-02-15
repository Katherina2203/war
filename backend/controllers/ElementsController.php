<?php
namespace backend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\helpers\Json;
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
              //  'only' => ['index', 'view','create'],
                'rules' => [
                    [
                      //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['head', 'admin', 'Purchasegroup', 'manager'],
                        'actions' => ['createfrom', 'createreturn', 'create', 'viewfrom', 'tostock', 'createreceipt', 'update', 'viewcat', 'createfromquick'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view', 'orderquick'],
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
     * Lists all Elements models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelprice = new Prices();
        $searchModelprice = new PricesSearch();
        $dataProviderprice = $searchModelprice->search(Yii::$app->request->queryParams);
     
        $modelrequests = new Requests();
        $searchModelrequests = new RequestsSearch();
        $dataProviderrequests = $searchModelrequests->search(Yii::$app->request->queryParams);
       
        $model = new Elements();
        $searchModel = new ElementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $modelacc = new Accounts();
        $queryacc = Accounts::find()->where(['idelem' => $model->idelements])->orderBy('date_receive DESC')->limit(10);
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
      
        return $this->render('index', [
                'model' => $model,
                'modelacc' => $modelacc,
                'searchModel' => $searchModel,
                'searchModelprice' => $searchModelprice,
                'dataProvider' => $dataProvider,
                'dataProviderprice' => $dataProviderprice,
                'modelprice' => $modelprice,
                'modelrequests' => $modelrequests, //for elements
                'searchModelrequests' => $searchModelrequests,
                'dataProviderrequests' => $dataProviderrequests,
                'dataProvideracc' => $dataProvideracc,
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
        
        //requests
        $modelrequests = new Requests();
        $modelrequests->idtype = '1';
        $modelrequests->status = '0';
        $modelrequests->iduser = yii::$app->user->identity->id;
       // if(\yii::$app->request->isAjax && $modelrequests->load(\yii::$app->request->post())){      
        if($modelrequests->load(\yii::$app->request->post())){      
           // \yii::$app->response->format = Response::FORMAT_JSON;
            $modelrequests->name = $model->name;
            $modelrequests->description = $model->nominal;
            $modelrequests->idproduce = $model->idproduce;
            $modelrequests->estimated_category = $model->idcategory;
            $modelrequests->estimated_idel = $model->idelements;
           // $result = ['success' => true, 'message' => 'Заявка успешно создана!'];
                if($modelrequests->idboard !=NULL){
                    //create shortage
                    Yii::$app->db->createCommand()->insert('shortage', [
                        'idboard' => $modelrequests->idboard, 
                        'idelement' => $model->idelements, 
                        'quantity' => $modelrequests->quantity, 
                        'status' => Shortage::STATUS_ACTIVE]
                        )->execute();
                }
            if($modelrequests->save(false)) {
                Yii::$app->session->setFlash('success', 'Товар успешно отправлен в заявку!');
                return $this->redirect(['elements/view', 'id' => $model->idelements]);
            }
            /*else{
                Yii::$app->session->setFlash('error', 'Возникла ошибка при создании заявки');
            }*/
        }
        // end requests
        
        $queryacc = Accounts::find()->where(['idelem' => $id])->orderBy('date_receive DESC')->limit(10);
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
        
        $querypur = Purchaseorder::find()->where(['idelement' => $id])->orderBy('created_at DESC')->limit(5);
    //    $countQuery = clone $querypur;
     //   $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $dataProviderpur = new ActiveDataProvider([
            'query' => $querypur,
        ]);  /*in future point the limit of requests..E.x. last 5 orders */
        
        $searchModelout = new OutofstockSearch();
        $queryout = Outofstock::find()->where(['idelement' => $id])->orderBy('date DESC');//
        $dataProviderout = new ActiveDataProvider([
            'query' => $queryout,
        ]);
        
        $searchModelreceipt = new \backend\models\ReturnitemSearch();
        $queryreceipt = Returnitem::find()->where(['idelement' => $id])->orderBy('created_at DESC');
        $dataProviderreceipt = new ActiveDataProvider([
            'query' => $queryreceipt,
        ]);
        
        $modelShortage = new Shortage();
        $queryShortage = Shortage::find()->where(['idelement' => $id])->andWhere(['status' => '1'])->orderBy('created_at DESC'); //show where need element
        $dataProviderShortage = new ActiveDataProvider([
            'query' => $queryShortage,
        ]);
        
        return $this->render('view', [
         //   'pages' => $pages,
            'model' => $this->findModel($id),
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'modelprice' => $modelprice,
            'modelrequests' => $modelrequests,
            'modelShortage' => $modelShortage,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderpur' => $dataProviderpur,
            'dataProviderout' => $dataProviderout,
            'dataProviderShortage' => $dataProviderShortage,
            'searchModelout' => $searchModelout,
            'searchModelreceipt' => $searchModelreceipt,
            'dataProviderreceipt' => $dataProviderreceipt,
        ]);
    }
    
    public function actionViewcat($idcategory){
        $searchModel = new ElementsSearch();
        
        $query = Elements::find()->where(['idcategory' => $idcategory])->With(['category', 'produce'])->orderBy('idcategory')->limit(80);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
        return $this->render('viewcat', [
            'model' => $this->findModel($idcategory),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionVieworder($id)
    {
        $model = new Elements();
       //show prices
        $model2 = new Prices();
        $searchModel2 = new PricesSearch();
        
        $query = Prices::find()->where(['idel' => $id])->orderBy('created_at DESC');
        $dataProvider2 = new ActiveDataProvider([
            'query' => $query,
        ]);
        //end show prices
        
        //requests
        $modelrequests = new Requests();
        
            
        $queryacc = Accounts::find()->where(['idelem' => $id])->orderBy('date_receive DESC');
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
        
        $querypur = Purchaseorder::find()->where(['idelement' => $id])->orderBy('created_at DESC');
        $dataProviderpur = new ActiveDataProvider([
            'query' => $querypur,
        ]);  /*in future point the limit of requests..E.x. last 5 orders */
        
        $searchModelout = new OutofstockSearch();
        $queryout = Outofstock::find()->where(['idelement' => $id])->orderBy('date DESC');//
        $dataProviderout = new ActiveDataProvider([
            'query' => $queryout,
        ]);
           
        return $this->render('vieworder', [
            'model' => $this->findModel($id),
            'searchModel2' => $searchModel2,
            'searchModelout' => $searchModelout,
            'dataProvider2' => $dataProvider2,
            'model2' => $model2,
            'modelrequests' => $modelrequests,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderpur' => $dataProviderpur,
            'dataProviderout' => $dataProviderout
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
                    $model->image = $imagePath;
                   // $model->image = 'images/' .  $imagePath;        //{$model->id}/{$model->media_file->name}
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
    
    public function actionCreateproduce()
    {
        $model = new Produce();
        
        if($model->load(\yii::$app->request->post()) && $model->save()) {
            //Yii::$app->getSession()->setFlash('success', 'Product has been created.');
            echo '1';
           // return $this->redirect(['view', 'id' => $model->idelements]);
      }elseif (Yii::$app->request->isAjax) {
          Yii::$app->getSession()->setFlash('success', 'Product has been created.');
            return $this->renderAjax('_formproduce', [
                        'model' => $model
            ]);
        }
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
           
        } else {
            return $this->render('createfrom', [
                'model' => $model,
                'user' => $user,
                'element' => $element,
                
            ]);
        }
    }
    
     public function actionCreatefromquick($idel, $iduser)
    {
        $model = new Outofstock();
        $model->idelement = $idel;
        $model->iduser = $iduser;
      //  $user = new Users();
      //  $user->id = $iduser;
        $element = new Elements();
        $element->idelements = $idel;
        
        $board = new \common\models\Boards();
        $board->idtheme = $model->idtheme;
        $board->idthemeunit = $model->idthemeunit;
        
        if ($model->load(Yii::$app->request->post())) {
            $board->idtheme = $model->idtheme=12;
            $board->idthemeunit = $model->idthemeunit=16;
        
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
           
        } else {
            return $this->render('createfromquick', [
                'model' => $model,
             //   'user' => $user,
                'element' => $element,
                'board' => $board,
            ]);
        }
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
    
    public function actionOrderquick($iduser, $idel)
    {
        $model = new Requests();
        $model->idtype = '1';
        $model->status = '0';
        $model->iduser = $iduser;
        
        $modelel = Elements::findOne($idel);

     //   if($modelel->active = 1){ //if element не устарел
        if ($model->load(Yii::$app->request->post())) {
                $model->name = $modelel->name;// $idel . ', ' 
                $model->description = $modelel->nominal;
                $model->idproduce = $modelel->idproduce;
                $model->estimated_category = $modelel->idcategory;
                
                if($model->save(false)) {   
                    Yii::$app->session->setFlash('success', 'Товар успешно отправлен в заявку!');
                    return $this->redirect(['elements/view', 'id' => $modelel->idelements]);
                }else{
                    Yii::$app->session->setFlash('error', 'Возникла ошибка при создании заявки');
                }
        } else {
            return $this->render('orderquick', [
                'model' => $model,
                'modelel' => $modelel,
            ]);
        }
      //  }else{
      //       throw new NotFoundHttpException('Данная позиция устарела. Поищите аналог.');
      //  }
       
    }
    
    public function actionCreateprice($idel)
    {
        $model = new Elements();
        $modelprice = new Prices();
        $modelprice->idel = $idel;
        
        if ($modelprice->load(Yii::$app->request->post()) && $modelprice->save()){
             return $this->redirect(['view', 'id' => $modelprice->idel]);
        }else {
            return $this->render('createprice', [
                'modelprice' => $modelprice,
                'model' => $model,
            ]);
        }
        
    }
    
    public function actionCreatereturn($idel, $iduser)
    {
        $return = new Returnitem();
        $return->idelement = $idel;
        //$return->created_by = $iduser;
        
        if ($return->load(Yii::$app->request->post())) {
     
           $transaction = $return->getDb()->beginTransaction(//Yii::$app->db->beginTransaction(
                 //   Transaction::SERIALIZABLE
                    );
            try{
                $valid = $return->validate();
                Yii::$app->db->createCommand()->update('elements', ['quantity' => new Expression('quantity + :modelquantity', [':modelquantity' => $return->quantity])],['idelements' => $return->idelement])->execute();
               
                if ($valid) {
                // the model was validated, no need to validate it once more
                    $return->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Данная позиция успешно возвращена на склад!');
                    return $this->redirect(['view', 'id' => $return->idelement]);
                } else {
                    $transaction->rollBack();
                } 
                
           }catch (ErrorException $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();
            }
             
        }else{
                return $this->render('createreturn', [
                'return' => $return,

            ]);
            }
        
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
        $modelacc->idelem = $idel;
        $searchModelacc = new AccountsSearch();
        
        $query = Accounts::find()->where(['idelem' => $idel])->orderBy('date_receive DESC');
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
