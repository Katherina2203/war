<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

use common\models\Currency;
/* @var $model common\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row"><div class="col-md-6">
<div class="addtoinvoice-form">
    <div class="box box-solid">
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'idelem')->textInput(['disabled' => true]) ?>

        <?= $form->field($model, 'idprice')->textInput() ?>
      
        <?= $form->field($model, 'idinvoice')->textInput(); ?>
            
            <?= $form->field($modelpr, 'idsup')->textInput()  ?>
            
            <div class="row">
            <div class="col-sm-6">
            <?= $form->field($modelpr, 'unitPrice')->textInput(['maxlength' => true]) ?>
            </div> 
             <div class="col-sm-6">
            <?= $form->field($modelpr, 'forUP')->textInput(['maxlength' => true, 'placeholder' => 'Цена за единицу товара']) ?>
                 </div></div>
            
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($modelpr, 'idcurrency')->dropDownList(Currency::find()->select(['currency', 'idcurrency'])->indexBy('idcurrency')->column(),    ['prompt'=>'Выберите валюту']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelpr, 'pdv')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelpr, 'usd')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

    <?= $form->field($model, 'quantity')->textInput(['style' => 'width: 150px;']) ?>
    
   

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
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'delivery')->textInput(['maxlength' => true]) ?>
                </div>
                 <div class="col-sm-6">
                    <?= $form->field($model, 'date_receive')->widget(
                    DatePicker::className(), [
                        'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                    ]);?>
                </div>
            </div>
            
        <?php //  $form->field($model, 'status')->radioList([ '2' => ' Заказано', '3' => ' На складе'], ['prompt' => '']) //by default ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
      </div>
      
  </div>
</div>
</div></div>
