<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use kartik\grid\EditableColumnAction;

use common\models\LoginForm;

use common\models\Requests;
use backend\models\RequestsSearch;
use common\models\Paymentinvoice;
use backend\models\ElementsSearch;
use common\models\Processingrequest;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],//, 'signup'
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['error'],
                    ],
                    [
                        'allow' => true,
                       // 'actions' => ['index', 'logout'],
                        'roles' => ['@'],
                    ],
                  ],
              ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'language' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'page' => [
                'class' => \yii\web\ViewAction::className(),
                'viewPrefix' => 'pages/' . \Yii::$app->language
            ],
            'confirm' => [                                       // identifier for your editable column action
               'class' => EditableColumnAction::className(),     // action class name
               'modelClass' => Paymentinvoice::className(),                // the model for the record being edited
               'outputValue' => function ($model, $attribute, $key, $index) {
                    // return (int) $model->$attribute / 100;      // return any custom output value if desired
                    return (int) $model->$attribute;  
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error to return after model save
               },
               'showModelErrors' => true,                        // show model validation errors after save
               'errorOptions' => ['header' => '']                // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
               // 'findModel' => function($id, $action) {},
               // 'checkAccess' => function($action, $model) {}
           ],
        ];
    }

    public function actionIndex()
    {
     /*   if (!Yii::$app->user->isGuest) {
           // return $this->redirect(['/myaccount/']);
              return $this->redirect(['/myaccount/']);
            
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }else{
             return $this->render('login', [
                'model' => $model,
            ]);
        }
        */
        $modelrequests = new Requests();
        $modelrequests->idtype = '1';
        $modelrequests->iduser = yii::$app->user->identity->id;
        $modelproc = new Processingrequest();
        $searchModelreq = new RequestsSearch();
        $searchElements = new ElementsSearch();
        
        $query = Requests::find()->where(['status' => '0'])->with(['themes', 'supplier'])->orderBy('created_at DESC'); 
        $dataProviderreq = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'pageSize' => 6,
            ]
        ]);
        if (Yii::$app->request->isAjax && $modelrequests->load(Yii::$app->request->post())) {
              //  $modelrequests->iduser = yii::$app->user->identity->id;
               
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if($modelrequests->save()){
                Yii::$app->session->setFlash('success', 'Заявка успешно сохранена');
                return $this->redirect(['index']);
            }
        } 
        /*else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
        
      //  if($modelrequests->idrequest != $modelproc->idrequest){
        $dataProviderconf = new ActiveDataProvider([
            'query' => Requests::find()->where(['status' => '0'])->asArray(),
        ]);
         $modelpay = new Paymentinvoice();

        $dataProviderpay = new ActiveDataProvider([
            'query' =>  Paymentinvoice::find()->where(['date_payment' => NULL])->asArray(),
        ]);
        //end view invoices
        
        
        return $this->render('index', [
           
            'modelrequests' => $modelrequests,
            'modelpay' => $modelpay,
            'searchModelreq' => $searchModelreq,
            'dataProviderreq' => $dataProviderreq,
            'dataProviderconf' => $dataProviderconf,
            'dataProviderpay' => $dataProviderpay,
            'searchElements' => $searchElements,
        ]);
    }
    
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
         //    return $this->redirect(Yii::$app->user->loginUrl);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
            
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionLanguage()
    {
        if ( Yii::$app->request->post('_lang') !== NULL && array_key_exists(Yii::$app->request->post('_lang'), Yii::$app->params['languages']))
        {
            Yii::$app->language = Yii::$app->request->post('_lang');
            $cookie = new yii\web\Cookie([
            'name' => '_lang',
            'value' => Yii::$app->request->post('_lang'),
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        Yii::$app->end();
    }
}
