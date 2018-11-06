<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

use common\models\Themes;
use common\models\Boards;
use common\models\Users;
/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outofstock-formquick">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); 
      //   $themes = Themes::find()->where(['status' => 'active'])->all();
       //  $themeList = ArrayHelper::map($themes,'idtheme', 'name');
         
        // $users = Users::find()->where(['id' => '4']);
         ?>
    <div class="row">
         <div class="col-sm-6">
             <span>Номер платы: <?= $model->idtheme. '-'. $model->idthemeunit;?></span><h4><i class="glyphicon glyphicon-hdd"></i> <?= Html::encode($this->title) ?></h4>
        </div>
      
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Addresses</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $model,
                'formId' => 'dynamic-form',
                'formFields' => [
                    'full_name',
                    'address_line1',
                    'address_line2',
                    'city',
                    'state',
                    'postal_code',
                ],
            ]); ?>
    </div>
    <div class="container-items">
         <div class="container-items"><!-- widgetContainer -->
          
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Address</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                     
                        <div class="row">
                           <?= $form->field($model, 'idelement')->textInput(['style'=>'width:100px']) ?>

     <?php // $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
         //   ['prompt'=>'Select Person'])  ?>

    <?= $form->field($model, 'quantity')->textInput(['style'=>'width:150px']) ?>

    

    <?= $form->field($model, 'ref_of_board')->textInput(['maxlength' => true]) ?>
                        </div><!-- .row -->
                        
                    </div>
                </div>
         
            </div>
            <?php DynamicFormWidget::end(); ?>
        
        
    </div>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    </div>
