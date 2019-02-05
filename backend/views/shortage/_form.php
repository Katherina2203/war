<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shortage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shortage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idboard')->textInput() ?>

    <?= $form->field($model, 'ref_of')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idelement')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
