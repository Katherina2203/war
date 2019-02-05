<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\detail\DetailView;

use common\models\Supplier;
use common\models\Payer;
?>

<div class="paymentinvoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

   

    <?= DetailView::widget([
        'model' => $modelPayment,
        'attributes' => [
            'idpaymenti',
            'invoice',
            'date_invoice',
            'idpayer',
            'date_payment',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

<div class="paymentinvoice-form">
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
 <!--   <div class="row">
        <div class="col-sm-6">
            <?php // $form->field($model, 'idsupplier')->dropDownList(ArrayHelper::map(Supplier::find()->all(), 'idsupplier', 'name')) ?>
        </div>
        <div class="col-sm-6">
            <?php // $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?php /* $form->field($model, 'date_invoice')->widget(
                  DatePicker::className(), [
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                  ]
                ]);*/?>
        </div>
        <div class="col-sm-6">
             <?php // $form->field($model, 'idpayer')->dropDownList(ArrayHelper::map(common\models\Payer::find()->all(), 'idpayer', 'name'),
                // ['prompt'=>'Выберите плательщика']) ?>
        </div>
       
    </div>-->
 
    
    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Items in the invoice</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsAccounts[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'idprice',
                    'quantity',
                    'amount',
                    'delivery',
                    'status',
                    'date_receive',
                ],
            ]); ?>
            
            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsAccounts as $i => $modelAccounts): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Items</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelAccounts->isNewRecord) {
                                echo Html::activeHiddenInput($modelAccounts, "[{$i}]id");
                            }
                        ?>
                        <?= $form->field($modelAccounts, "[{$i}]idprice")->textInput(['maxlength' => true]) ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelAccounts, "[{$i}]quantity")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAccounts, "[{$i}]amount")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelAccounts, "[{$i}]delivery")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAccounts, "[{$i}]status")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAccounts, "[{$i}]date_receive")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($modelAccounts->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    
    <?php ActiveForm::end(); ?>
</div>
<script>
$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
</script>

