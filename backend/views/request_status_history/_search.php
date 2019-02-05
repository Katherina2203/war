<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RequestStatusHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-status-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idreqstatus') ?>

    <?= $form->field($model, 'idrequest') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'edited_by') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
