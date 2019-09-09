<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */
/* @var $form yii\widgets\ActiveForm */
use common\models\Supplier;
?>

<div class="paymentinvoice-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); 
          $suppliers = Supplier::find()->select(['name' , 'idsupplier'])->indexBy('idsupplier')->column();
    ?>
    
    <?= $form->field($model, 'idsupplier')->widget(Select2::className(),[
        'data' => $suppliers,
        'options' => ['placeholder' => 'Выберите производителя '],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]);
            //->dropDownList(ArrayHelper::map(Supplier::find()->all(), 'idsupplier', 'name')) ?>
<div class="row">
    <div class="col-sm-4">
         <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
         <?= //$form->field($model, 'date')->textInput() 
        $form->field($model, 'date_invoice')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    </div>
    <div class="col-sm-4">
         <?= $form->field($model, 'usd')->textInput() ?>
    </div>
</div>
       
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
    
    <?php echo $form->field($model, 'confirm')->radioList(['1' => 'Подтверждем', '0' => 'Не подтвержден', '2'=> 'Отмена']) ?>
    <div class="row">        
    <div class="col-sm-6">
                <?= $form->field($model, 'tracking_number')->textInput(['maxlength' => true]) ?>
            </div>
     </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
