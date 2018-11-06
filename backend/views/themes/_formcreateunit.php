<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-theme-createunit col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelunit, 'nameunit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelunit, 'quantity_required')->textInput(['style' => 'width: 150px']) ?>
    
     <?= $form->field($modelunit, 'idtheme')->dropDownList(\common\models\Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->column(),    ['prompt'=>'']) ?>

    <div class="form-group">
        <?= Html::submitButton($modelunit->isNewRecord ? 'Create' : 'Update', ['class' => $modelunit->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
