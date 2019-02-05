<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\Status;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

use common\models\Purchaseorder;
use common\models\Prices;
use common\models\Requests;
/* @var $model common\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-formitem col-md-8">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
        ]); 
      //  $iduser = yii::$app->user->identity->id;
        $request = new Requests();
     //   $request->status = '3';//Requests::REQUEST_ACTIVE;
        
        $elements = Purchaseorder::find()
                //->where(['idrequest' => $request->status = '0'])
                ->all();
     //   $elemList = ArrayHelper::map($elements, 'idpo', 'elements.fulname');
     /*   $elemList = ArrayHelper::getValue($elements, function ($elements) {
                return $elements->idelement;// . ', '. $elements->elements->name . ', ' . $elements->elements->nominal;
            });*/
       // $elemList = Purchaseorder::getOrderitem();
    // $myorders = \common\models\Processingrequest::find()->where(['idresponsive' => $iduser])->all();
     $price = Prices::find()->select(['unitPrice', 'forUP'])
            // ->where(); //idelement = purchaseorder.element
             ->column();
    ?>

    <?= $form->field($model, 'idelem')->textInput() ?>

   
        <?= $form->field($model, 'idprice')->textInput() 
            ?>


    <?= $form->field($model, 'quantity')->textInput(['style' => 'width: 150px;']) ?>
    
    <?php // $form->field($model, 'idinvoice')->textInput(); ?>

    <?php /*$form->field($model, 'account_date')->textInput() 
        $form->field($model, 'account_date')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => true])*/ ?>
    <?= $form->field($model, 'amount')->textInput() 
            //formula quantity * price
            ?>
    <?= $form->field($model, 'delivery')->textInput(['maxlength' => true]) ?>

    <?= //$form->field($model, 'date_receive')->textInput() 
        $form->field($model, 'date_receive')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    
    <?php //  $form->field($model, 'status')->radioList([ '2' => ' Заказано', '3' => ' На складе'], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).on('ready', function(ev) {
    // Child # 1 themeunit dependent only on idtheme
    $(".field-accounts-formitem-idprice").depdrop({
        depends: ['idelem'],
        url: '/processingrequest/price'
    });
</script>
