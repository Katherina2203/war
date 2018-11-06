<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BoardsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elements-search">

    <?php $form = ActiveForm::begin([
        'action' => ['view'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'nominal') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('Добавить', ['outofstock/quickcompl', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
                       
    </div>

    <?php ActiveForm::end(); ?>

</div>
