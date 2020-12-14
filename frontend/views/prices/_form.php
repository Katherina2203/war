<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Currency;
/* @var $this yii\web\View */
/* @var $model common\models\Prices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idsup')->dropDownList(ArrayHelper::map(Supplier::find()->all(), 'idsupplier', 'name')) ?>

    <?= $form->field($model, 'unitPrice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forUP')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'idcurrency')->dropDownList(Currency::find()->select(['currency', 'idcurrency'])->indexBy('idcurrency')->column(),    ['prompt'=>'Выберите валюту']) ?>

    <?= $form->field($model, 'pdv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usd')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
