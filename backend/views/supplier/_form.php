<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model common\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#new_supplier").on("pjax:end", function() {
            $.pjax.reload({container:"#suppliers"});  //Reload GridView
        });
    });'
    );
?>
<div class="row"><div class="col-md-6">
    <div class="supplier-form">
        <div class="box box-solid">
            <div class="box-body">
            <?php Pjax::begin(['id'=>'new_supplier']) ?>
                <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, ]) ?>
                    <?= $form->field($model, 'address')->textInput(['rows' => 2]) ?>
                    <?= $form->field($model, 'manager')->textInput(['placeholder'=> 'Name Surname'])//->hint('Please enter name') ?> 
                    <?= $form->field($model, 'phone')->textInput() ?>
                    <?= $form->field($model, 'logo')->textInput() ?>
                    <?= $form->field($model, 'website')->textInput(['placeholder'=> 'http://']) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
             <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div></div>
