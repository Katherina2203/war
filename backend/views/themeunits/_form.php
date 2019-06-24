<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row"><div class="col-md-6">
<div class="themeunits-form">
    <div class="box box-solid">
            <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idtheme')->dropDownList(\common\models\Themes::find()->select(['name', 'idtheme'])->andWhere(['status' => 'active'])->indexBy('idtheme')->column(),    ['prompt'=>'']) ?>

    <?= $form->field($model, 'nameunit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity_required')->textInput(['style' => 'width: 150px']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'close' => 'Close', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div></div>
</div>
        
</div></div>