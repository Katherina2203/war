<?php
namespace backend\components;

use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends yii\web\User
{
    public function getPhoto()
    {
        return \Yii::$app->user->identity->photo;
    }
}