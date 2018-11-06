<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */
/* @var $form yii\widgets\ActiveForm */
use common\models\Users;
?>

<div class="processingrequest-form">

    <?php $form = ActiveForm::begin(); ?>
     <?=  $form->field($model, 'idresponsive')->dropDownList(Users::find()->select(['name', 'surname','id'])->where(['id' => 33])->indexBy('id')->column(), 
    ['prompt'=>'']); 
            ?>

    <?= $form->field($model, 'idrequest')->textInput(['style'=>'width:100px'])?>
    
    <?= $form->field($model, 'idpurchasegroup')->radioList(\common\models\Users::find()->select(['surname','id'])->where(['role' => '2'])->indexBy('id')->column(),
            ['prompt'=>'']); 
            ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
