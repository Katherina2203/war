<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PricesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prices-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'idpr') ?>

    <?= $form->field($model, 'idel') ?>

    <?= $form->field($model, 'idsup') ?>

    <?php // $form->field($model, 'unitPrice') ?>

    <?php // $form->field($model, 'forUP') ?>

    <?php // echo $form->field($model, 'pdv') ?>

    <?php // echo $form->field($model, 'usd') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
