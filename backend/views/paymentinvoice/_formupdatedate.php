<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */
/* @var $form yii\widgets\ActiveForm */

?>
<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#update_request_date").on("pjax:end", function() {
            $.pjax.reload({container:"#produces"});  //Reload GridView
        });
    });'
    );
?>
<div class="paymentinvoice-form">
<?php Pjax::begin(['id' => 'update_request_date']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); 

    ?>

    <?= //$form->field($model, 'date')->textInput() 
        $form->field($model, 'date_payment')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    


    <div class="form-group">
        <?= Html::submitButton('Update', ['btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
</div>
