<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
//use yii\helpers\ArrayHelper;
//use yii\helpers\Url;
///use kartik\depdrop\DepDrop;

//use common\models\Themes;
//use common\models\Boards;
//use common\models\Users;
/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outofstock-form">

    <?php $form = ActiveForm::begin(); 
    //    $themes = Themes::find()->where(['status' => 'active'])->all();
       //  $themeList = ArrayHelper::map($themes,'idtheme', 'name');
         ?>

    <?= $form->field($model, 'idelement')->textInput(['style'=>'width:100px']) ?>

  
    <?= $form->field($model, 'quantity')->textInput(['style'=>'width:150px']) ?>

    <?= $form->field($model, 'ref_of_board')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
