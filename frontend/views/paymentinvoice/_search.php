<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentinvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paymentinvoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idpaymenti') ?>

    <?= $form->field($model, 'invoice') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'idpayer') ?>

    <?= $form->field($model, 'date_payment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php // обновляем грид под формой с оплатой внутри модального окна
    $this->registerJs(
        '$("document").ready(function(){
            $(".paymentinvoice-search").val("");
        });
    });'
    );
?>
