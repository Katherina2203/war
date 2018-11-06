<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Projectshortcut */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projectshortcut-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'status')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>
    <?= $form->field($model, 'category')->dropDownList(common\models\Categoryshortcut::getHierarchy(), ['prompt' => 'Выберите категорию']) ?>
    
    <?= $form->field($model, 'significance')->radioList(common\models\Projectshortcut::getSignificance()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
