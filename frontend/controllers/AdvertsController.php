<?php

namespace frontend\controllers;
use \yii\web\Controller;

use common\models\Adverts;
/**
 * Description of AdvertsController
 *
 * @author КАТЕРИНА
 */
class AdvertsController extends Controller
{
    public function actionIndex()
    {
        $model = Adverts::find()->all();
      // $searchmodel = new \backend\models\AdvertsSearch;
        
        
        
        return $this->render('index',[
            'model' => $model,
        ]);
    }
}
