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

<div class="createprice-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelprice, 'idsup')->dropDownList(ArrayHelper::map(Supplier::find()->all(), 'idsupplier', 'name')) ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($modelprice, 'unitPrice')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($modelprice, 'forUP')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($modelprice, 'idcurrency')->dropDownList(Currency::find()->select(['currency', 'idcurrency'])->indexBy('idcurrency')->column(),    ['prompt'=>'Выберите валюту']) ?>
        </div>
    </div>
    <?= $form->field($modelprice, 'pdv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelprice, 'usd')->textInput(['maxlength' => true]) ?>
    
     <?= $form->field($modelprice, 'idel')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($modelprice->isNewRecord ? 'Create' : 'Update', ['class' => $modelprice->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
