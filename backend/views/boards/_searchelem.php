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
         <div class="col-lg-2">
            <?= $form->field($searchModelelem, 'idelements')->textInput(['placeholder' => 'Search by Id element']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($searchModelelem, 'name')->textInput(['placeholder' => 'Search by Name']) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($searchModelelem, 'nominal')->textInput(['placeholder' => 'Search by Nominal']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('Добавить', ['outofstock/quickcompl', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
                       
    </div>

    <?php ActiveForm::end(); ?>

</div>
