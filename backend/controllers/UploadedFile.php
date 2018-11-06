<?php
namespace app\modules\admin\controllers;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function actionUploadedFile()
    {
    $model = new Elements();
    if (!empty($_POST)) {
        $model->image = $_POST['elements']['image'];
        $file = \yii\web\UploadedFile::getInstance($model, 'image');
        var_dump($file);

        // You can then do the following
        if ($model->save()) {
            $file->saveAs('@web/images');
        }
        // its better if you relegate such a code to your model class
    }
    return $this->render('upload', ['model'=>$model]);
    }
    ?>
