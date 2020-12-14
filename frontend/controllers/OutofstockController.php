<?php
namespace frontend\modules\controllers;

use yii;
use yii\web\Controller;

class OutofstockController extends Controller
{
    public function actionUserout()
    {
        return $this->render('userout');
    }
}
