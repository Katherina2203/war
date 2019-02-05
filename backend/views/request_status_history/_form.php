<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RequestStatusHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-status-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idrequest')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ '0', '1', '2', '3', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'edited_by')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
