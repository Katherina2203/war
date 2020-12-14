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

    <?= $form->field($model, 'idrequest')->textInput() ?>

    <?= $form->field($model, 'idelement')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput(['style' => 'width: 100px;']) ?>

    <?= $form->field($model, 'date')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    
    <?= $form->field($model, 'idinvoice')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
