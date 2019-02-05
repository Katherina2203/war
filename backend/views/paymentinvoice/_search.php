<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentinvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
$getsupplier = ArrayHelper::map(common\models\Supplier::find()->select(['name', 'idsupplier'])->asArray()->all(), 'idsupplier', 'name');
$getpayer = ArrayHelper::map(common\models\Payer::find()->select(['idpayer', 'name'])->asArray()->all(), 'idpayer', 'name');
?>

<div class="paymentinvoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="row">
        <?php // $form->field($model, 'idpaymenti') ?>
    <div class="col col-md-6">
        <?= $form->field($model, 'idsupplier')->dropDownList($getsupplier,
                    ['prompt'=>'Выберите поставщика'])?>
    </div>
    <div class="col col-md-6">
        <?= $form->field($model, 'invoice') ?>
    </div>

    <?php // $form->field($model, 'date_invoice') ?>
    <div class="col col-md-6">
    <?= $form->field($model, 'idpayer')->dropDownList($getpayer,
                    ['prompt'=>'Выберите плательщика'])?>
    </div>
</div>
    <?php // echo $form->field($model, 'date_payment') ?>

    <?php // echo $form->field($model, 'confirm') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerJs(
        '$("document").ready(function(){
            $(".paymentinvoice-search").val("") 
        });'
    );
?>

