<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BoardsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="boards-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idboards') ?>

    <?= $form->field($model, 'idtheme') ?>

    <?= $form->field($model, 'idthemeunit') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'current') ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'discontinued') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
