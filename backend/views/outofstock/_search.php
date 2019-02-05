<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OutofstockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outofstock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idofstock') ?>

    <?= $form->field($model, 'idelement') ?>

    <?= $form->field($model, 'iduser') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'idtheme') ?>

    <?php // echo $form->field($model, 'idthemeunit') ?>

    <?php // echo $form->field($model, 'idboart') ?>

    <?php // echo $form->field($model, 'ref_of_board') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
