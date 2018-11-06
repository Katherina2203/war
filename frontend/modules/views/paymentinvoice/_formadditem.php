<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\Status;
/* @var $model common\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelsAccounts, 'idelem')->textInput() ?>

    <?= $form->field($modelsAccounts, 'idprice')->textInput() ?>
<div class="row">
    <div class="col-md-6">
    <?= $form->field($modelsAccounts, 'quantity')->textInput()//['style' => 'width: 150px;'] ?>
    </div>
    <?php // $form->field($modelsAccounts, 'idinvoice')->textInput(); ?>

    <div class="col-md-6">
    <?= $form->field($modelsAccounts, 'amount')->textInput(); ?>
        
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    <?= $form->field($modelsAccounts, 'delivery')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
    <?= $form->field($modelsAccounts, 'date_receive')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    </div>
    <div class="col-md-4">
    <?=  $form->field($modelsAccounts, 'status')->radioList([ '2' => 'Заказано', '3' => 'На складе'], ['prompt' => '']) ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton($modelsAccounts->isNewRecord ? 'Create' : 'Update', ['class' => $modelsAccounts->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
