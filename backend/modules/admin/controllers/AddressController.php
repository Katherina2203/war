<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
class AddressController extends Controller
{
   
     protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
