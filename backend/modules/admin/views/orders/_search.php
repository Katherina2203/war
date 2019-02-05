<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idorder') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'req_quantity') ?>

    <?= $form->field($model, 'idproduce') ?>

    <?= $form->field($model, 'idsupplier') ?>

    <?php // echo $form->field($model, 'req_date') ?>

    <?php // echo $form->field($model, 'executor') ?>

    <?php // echo $form->field($model, 'aggr_date') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'suppl_date') ?>

    <?php // echo $form->field($model, 'date_payment') ?>

    <?php // echo $form->field($model, 'contract') ?>

    <?php // echo $form->field($model, 'date_onstock') ?>

    <?php // echo $form->field($model, 'date_recept') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'idtheme') ?>

    <?php // echo $form->field($model, 'iduser') ?>

    <?php // echo $form->field($model, 'idstatus') ?>

    <?php // echo $form->field($model, 'additional') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
