<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'idord') ?>

    <?= $form->field($model, 'idelem') ?>

    <?php // $form->field($model, 'idprice') ?>

    <?php // $form->field($model, 'quantity') ?>
     <?php  echo $form->field($model, 'account') ?>

    <?php // $form->field($model, 'account_date') ?>

   

    <?php // echo $form->field($model, 'delivery') ?>

    <?= $form->field($model, 'status')->radioList(['2' => 'Заказано', '3' => 'На складе']); ?>

    <?php // echo $form->field($model, 'date_receive') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
