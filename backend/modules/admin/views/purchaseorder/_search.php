<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idpo') ?>

    <?php // $form->field($model, 'idaccount') ?>

    <?= $form->field($model, 'idelement') ?>

    <?php // $form->field($model, 'quantity') ?>

    <?php // $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
