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

    <?php $form = ActiveForm::begin([ 
                   'id' => 'form-add-intoinvoice', 
                    'enableAjaxValidation' => true, 
                 //   'validationUrl' => Yii::$app->urlManager->createUrl('contacts/contacts/contact-validate')
                ]); ?>

        <?= $form->field($model, 'idelem')->textInput(['disabled' => true]) ?>

        <?php // $form->field($model, 'idprice')->textInput() ?>
      
        <?= $form->field($model, 'idinvoice')->textInput(); ?>
            
            <span>________</span>
            <?= $form->field($modelpr, 'idsup')->dropDownList(common\models\Supplier::find()->select(['name'])->indexBy('idsupplier')->column(), ['prompt'=>'Выберите поставщика'])  ?>
            
            <div class="row" >
            <div class="col-sm-6">
            <?= $form->field($modelpr, 'unitPrice')->textInput(['maxlength' => true]) ?>
            </div> 
             <div class="col-sm-6">
            <?= $form->field($modelpr, 'forUP')->textInput(['maxlength' => true, 'placeholder' => 'Цена за единицу товара']) ?>
                 </div></div>
            
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($modelpr, 'idcurrency')->dropDownList(Currency::find()->select(['currency', 'idcurrency'])->indexBy('idcurrency')->column(),    ['prompt'=> yii::t('app', 'Select currency')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelpr, 'pdv')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelpr, 'usd')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <span>________</span>
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

<?php
$script = <<< JS

   $(document).ready(function () { 
        $("#form-add-intoinvoice").on('beforeSubmit', function (event) { 
            event.preventDefault();            
            var form_data = new FormData($('#form-add-intoinvoice')[0]);
            $.ajax({
                   url: $("#form-add-intoinvoice").attr('action'), 
                   dataType: 'JSON',  
                   cache: false,
                   contentType: false,
                   processData: false,
                   data: form_data, //$(this).serialize(),                      
                   type: 'post',                        
                   beforeSend: function() {
                   },
                   success: function(response){                         
                       toastr.success("",response.message);     
                           alert('working');
                   },
                   complete: function() {
                   },
                   error: function (data) {
                      toastr.warning("","There may a error on uploading. Try again later");    
                   }
                });                
            return false;
        });
    });       

JS;
$this->registerJs($script);
?>
