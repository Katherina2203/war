<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProcessingrequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="processingrequest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idprocessing') ?>

    <?= $form->field($model, 'idresponsive') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'idpayer') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
