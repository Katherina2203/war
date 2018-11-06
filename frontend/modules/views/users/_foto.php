<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

    
<div class="users-form">
    <div class="row">
    <div class="clearfix"></div>
    <div class="col-lg-6">
        
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
        <span>Загрузить фото</span>
    <?= $form->field($model, 'photo')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        // 'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']],
    ]);   ?>
  
    

    <?php ActiveForm::end(); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>
        </div>
    <div class="col-lg-4">
         <img src="<?= Url::to('@web/images/'.Yii::$app->user->identity->photo) ?>" class="img-circle" alt="<?= Yii::$app->user->identity->surname?>"/>
    </div>
</div>
</div>
