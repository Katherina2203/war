<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Model;
use backend\models\Modelo01;
use backend\models\Modelo03;
use backend\models\Modelo04;
use backend\models\Modelo05;
use backend\models\Implicados;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Planificacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outofstock-form">

   
   
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items2', // required: css class selector
                'widgetItem' => '.item2', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item2', // css class
                'deleteButton' => '.remove-item2', // css class
                'model' => $modelsModelo03[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'cargo_fk',
                    'medida_apl_fk',
                    'modelo03_cant',
                    'dic_fk',                   
                ],
            ]); ?>
<div class="panel panel-default">
        <div class="panel-heading">
          <h4><i class="glyphicon glyphicon-envelope"></i>Order Items
            <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
          </h4>
        </div>
      <div class="panel-body">
        <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($modelOrderItems as $orderItem => $modelOrderItem): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <h3 class="panel-title pull-left">Order items</h3>
                    <div class="pull-right">
                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php
                        // necessary for update action.
                        if (! $modelOrderItem->isNewRecord) {
                            echo Html::activeHiddenInput($modelOrderItem, "[{$orderItem}]id");
                        }
                    ?>
                    <div class="row">
                      <?= Html::activeLabel($modelOrderItem, 'product_id', ['label'=>'Product', 'class'=>'col-sm-1 control-label']) ?>
                      <div class="col-sm-2">
                        <?= $form->field($modelOrderItem, "[{$orderItem}]product_id")->dropDownList(ArrayHelper::map(Product::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),['prompt'=>'Select Product']); ?>
                      </div>
                      <?= Html::activeLabel($modelOrderItem, 'quantity', ['label'=>'Quantity', 'class'=>'col-sm-1 control-label']) ?>
                      <div class="col-sm-2">
                        <?= $form->field($modelOrderItem, "[{$orderItem}]quantity")->textInput(['maxlength' => true]) ?>
                      </div>
                      <?= Html::activeLabel($modelOrderItem, 'price', ['label'=>'Price', 'class'=>'col-sm-1 control-label']) ?>
                      <div class="col-sm-2">
                        <?= $form->field($modelOrderItem, "[{$orderItem}]price")->textInput(['maxlength' => true]) ?>
                      </div>
                      <?= Html::activeLabel($modelOrderItem, 'status_id', ['label'=>'Status', 'class'=>'col-sm-1 control-label']) ?>
                      <div class="col-sm-2">
                        <?= $form->field($modelOrderItem, "[{$orderItem}]status_id")->dropDownList(ArrayHelper::map(Status::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),['prompt'=>'Select Product']); ?>
                      </div>
                    </div><!-- .row -->
                </div>
              </div>
            <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php DynamicFormWidget::end(); ?>

      <div class="form-group">
        <div class="col-sm-12">
          <hr>
          <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
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