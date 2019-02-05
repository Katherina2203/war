<?php
namespace app\modules\admin\controllers;

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

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'searchModelprice' => $searchModelprice,
            'dataProvider' => $dataProvider,
            'dataProviderprice' => $dataProviderprice,
            'modelprice' => $modelprice,
            'modelrequests' => $modelrequests,
            'searchModelrequests' => $searchModelrequests,
            'dataProviderrequests' => $dataProviderrequests,
        ]);
    }
    /**
     * Displays a single Elements model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new Elements();
       //show prices
        $modelprice = new Prices();
        $searchModel2 = new PricesSearch();
        
        $query = Prices::find()->where(['idel' => $id])->orderBy('created_at DESC');
        $dataProvider2 = new ActiveDataProvider([
            'query' => $query,
        ]);
        //end show prices
        
        //requests
        $modelrequests = new Requests();
       // if(\yii::$app->request->isAjax && $modelrequests->load(\yii::$app->request->post())){      
        if($modelrequests->load(\yii::$app->request->post())){      
         //   \yii::$app->response->format = Response::FORMAT_JSON;
             $result = ['success' => true, 'message' => 'Заявка успешно создана!'];
        }
       // Yii::$app->response->format = Response::FORMAT_JSON;
     //   $result = ['success' => true, 'message' => 'Заявка успешно создана!'];
 
     // return $result;
       // $modelrequests->iduser = $iduser;
        
        // if ($model->load(Yii::$app->request->post()) && $modelrequests->load(Yii::$app->request->post())) {
           
         //   $model->name = $modelrequests->name;
          //  $model->nominal = $modelrequests->nominal;
          //  $model->idproduce = $modelrequests->nominal;
         //   $modelrequests->save();
         //    Yii::$app->response->format = 'json';
         //   return ['message' => Yii::t('app','Заявка успешно создана!'), 'id'=>$modelrequests->idrequest];
             
       //  }else{
        //      return $this->renderAjax('view', [
         //       'modelrequests' => $modelrequests,
        //    ]);
        // }
      //   
        // end requests
        
        $queryacc = Accounts::find()->where(['idelem' => $id])->orderBy('date_receive DESC');
        $dataProvideracc = new ActiveDataProvider([
            'query' => $queryacc,
        ]);
        
        $searchModelout = new OutofstockSearch();
        $queryout = Outofstock::find()->where(['idelement' => $id])->orderBy('date DESC');//
        $dataProviderout = new ActiveDataProvider([
            'query' => $queryout,
        ]);
           
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'modelprice' => $modelprice,
            'modelrequests' => $modelrequests,
            'dataProvideracc' => $dataProvideracc,
            'dataProviderout' => $dataProviderout,
            'searchModelout' => $searchModelout,
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
           
        return $this->render('vieworder', [
            'model' => $this->findModel($id),
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
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

    public function actionCreatefrom($idel, $iduser)
    {
        $model = new Outofstock();
        $model->idelement = $idel;
        $model->iduser = $iduser;
        $user = new Users();
        $user->id = $iduser;
        $element = new Elements();
        $element->idelements = $idel;

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
                //  $model->id = $modelacc->idelem;
                //  $model->idinvoice = $modelacc->idord;
               // $modelacc->status = '3';
                
                
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
                    return $this->redirect(['elements/view', 'id' => $return->idelement]);
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
