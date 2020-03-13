<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\helpers\ArrayHelper;
//use kartik\widgets\ActiveForm;
//use kartik\widgets\FileInput;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

use \common\models\Category;
use \common\models\Produce;
//use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Elements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elements-form">
    <div class="box box-success">
          <div class="box-header with-border"><h2 class="box-title"><?= Html::encode($this->title) ?></h2></div>
    <div class="box-body">
<?php Pjax::begin(['id' => 'new_element']) ?>
    <?php $form = ActiveForm::begin(['id' => 'element_form',
        'options' => [
            'enctype'=>'multipart/form-data',
            
        ],
//            'enableClientValidation' => true,
//            'enableAjaxValidation' => true
        ]); 
        $produce = Produce::find()->select(['manufacture', 'idpr'])->indexBy('idpr')->column();
        $category = Category::getHierarchy(); // Category::find()->select(['name', 'idcategory'])->indexBy('idcategory')->column();
    ?>

    <?= $form->field($model, 'box')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nominal')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
                <?= $form->field($model, 'idproduce')->widget(Select2::classname(),[
                   'data' => $produce,
                   'options' => ['placeholder' => 'Выберите производителя '],
                       'pluginOptions' => [
                           'allowClear' => true
                       ],
                   ]);?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'idcategory')->widget(Select2::className(),[
            'data' => $category,
            'options' => ['placeholder' => 'Выберите категорию '],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
                //->dropDownList(Category::getHierarchy(), ['prompt' => 'Выберите категорию'] );
            //->dropDownList(Category::find()->select(['name', 'idcategory'])->indexBy('idcategory')->column(),    ['prompt'=>'']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="tab-pane vertical-pad" id="image">
            <?= $form->field($model, 'image')
                    //->fileInput(['multiple' => true, 'accept' => 'images/*']); 
            ->widget(FileInput::classname(), [
                'pluginOptions' => [
                       
                      //  'browseClass' => 'btn btn-primary btn-block',
                    //    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                   //     'browseLabel' =>  'Upload Receipt'
                    ],
                'options' => ['accept' => 'image/*']
           // 'options' => ['accept' => 'images/*'],
            ]); 
            ?>
            </div>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'active')->radioList([ 
                '1' => 'актуально', 
                '2' => 'устарело', ], ['prompt' => 'Выберите актуальность товара']);  ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>
</div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
<?php
//$this->registerJs(
 // Вызов модального окна формы заказа
//   "$('#modalButtonProduce').on('click', function() {
//        $('#modalProduce').modal('show')
//            .find('#modal-content')
//            .load($(this).attr('data-target'));
//    });
//  "
   // );
?>