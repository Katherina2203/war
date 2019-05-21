<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\Status;
/* @var $model common\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addtoinvoice-form">
  <div class="box box-solid bg-gray-light" style="background: #fff;">
      
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idelem')->textInput(['disabled' => true]) ?>

        <?= $form->field($model, 'idprice')->textInput() ?>
      
        <?= $form->field($modelpr, 'idsup')->textInput()  ?>

        <?= $form->field($modelpr, 'unitPrice')->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelpr, 'forUP')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($modelpr, 'idcurrency')->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelpr, 'pdv')->textInput(['maxlength' => true]) ?>

        <?= $form->field($modelpr, 'usd')->textInput(['maxlength' => true]) ?>
            


    <?= $form->field($model, 'quantity')->textInput(['style' => 'width: 150px;']) ?>
    
    <?= $form->field($model, 'idinvoice')->textInput(); ?>

    <?php /*$form->field($model, 'account_date')->textInput() 
        $form->field($model, 'account_date')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => true])*/ ?>
    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'delivery')->textInput(['maxlength' => true]) ?>

    <?= //$form->field($model, 'date_receive')->textInput() 
        $form->field($model, 'date_receive')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    
    <?=  $form->field($model, 'status')->radioList([ '2' => ' Заказано', '3' => ' На складе'], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
      </div>
      
  </div>
</div>
