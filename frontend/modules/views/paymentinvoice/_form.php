<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */
/* @var $form yii\widgets\ActiveForm */
use common\models\Supplier;
?>

<div class="paymentinvoice-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'idsupplier')->dropDownList(ArrayHelper::map(Supplier::find()->all(), 'idsupplier', 'name')) ?>

    <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
    
    <?= //$form->field($model, 'date')->textInput() 
        $form->field($model, 'date_invoice')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>

       
    <?= $form->field($model, 'idpayer')->dropDownList(ArrayHelper::map(common\models\Payer::find()
        ->all(), 
        'idpayer', 'name'),
            ['prompt'=>'Выберите плательщика']) ?>
    
    <?= //$form->field($model, 'date')->textInput() 
        $form->field($model, 'date_payment')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    
     <?= $form->field($model, 'confirm')->radioList(['1' => 'Подтверждено', '0' => 'Не рассмотрено', '2'=> 'Отмена']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
