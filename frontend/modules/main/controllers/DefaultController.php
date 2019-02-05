<?php

namespace app\modules\main\controllers;

use frontend\components\Common;
use yii\web\Controller;
use yii\db\Query;

class DefaultController extends Controller
{

    public function actionIndex()
    {
      
        return $this->render('index');
    }

    public function actionService(){

        $locator = \Yii::$app->locator;
        $cache = $locator->cache;

        $cache->set("test",1);

        print $cache->get("test");

    }

   

    public function actionPath(){
        // @yii
        // @app
        //@runtime
        //@webroot
        //@web
        //@vendor
        //@bower
        //@npm
        // @frontend
        // @backend

        print \Yii::getAlias('@test');

    }

    public function actionCacheTest(){

        $locator = \Yii::$app->locator;
        $locator->cache->set('test',1);

        print   $locator->cache->get('test');


    }

    public function actionLoginData(){

        print \Yii::$app->user->identity->username;
    }
}
