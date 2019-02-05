<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
//use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($modelord, 'idrequest')->textInput() ?>

    <?php
    /*if ($modelord->idelement !=NULL){
        echo $form->field($modelord, 'idelement')->textInput();
    }else{
        echo $form->field($modelord, 'idelement')->textInput()->hint('idelement:'. $modelreq->estimated_idel);
    } */
    echo $form->field($modelord, 'idelement')->textInput();
     ?>

    <?= $form->field($modelord, 'quantity')->textInput(['style' => 'width: 100px;']) ?>

    <?= $form->field($modelord, 'date')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
        ]
        ]);?>

    <div class="form-group">
        <?= Html::submitButton($modelord->isNewRecord ? 'Create' : 'Update', ['class' => $modelord->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

