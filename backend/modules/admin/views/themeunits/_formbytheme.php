<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="themeunits-form col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'idtheme')->dropDownList(\common\models\Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->column(),    ['prompt'=>'']) ?>

    <?= $form->field($model, 'nameunit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity_required')->textInput(['style' => 'width: 150px']) ?>

    <?= $form->field($model, 'date_update')->widget(
        DatePicker::className(), [
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
        ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
