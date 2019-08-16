<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */
/* @var $form yii\widgets\ActiveForm */
use common\models\Themes;
?>
          
<div class="themeunits-form col-lg-6">
    <div class="box box-success">
         <div class="box-header with-border"><h2 class="box-title">Create unit for the project</h2></div>
        <div class="box-body">
                <?php $form = ActiveForm::begin(); 
                    $themes = Themes::find()->where(['status' => 'active'])->all();
                    $themeList = ArrayHelper::map($themes,'idtheme', 'name');
                ?>

                <?= $form->field($model, 'nameunit')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'quantity_required')->textInput(['style' => 'width: 150px']) ?>

                <?= $form->field($model, 'idtheme')
                        //->textInput(['readonly' => true, 'value' => $model->idtheme]) //$model->themes->name
                        ->dropDownList($themeList, ['id' => 'idtheme'],['prompt'=>''] )

                ?>
                <?= $form->field($model, 'status')->radioList(['active' => 'Active', 'close' => 'Close']) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
        </div>
    </div>               
</div>

   

