<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#update_paymentinvoice_confirm").on("pjax:end", function() {
            $.pjax.reload({container:"#paymentinvoice"});  //Reload GridView
        });
    });'
    );
?>

<div class="paymentinvoice-formupdateconfirm">
<?php Pjax::begin(['id' => 'update_paymentinvoice_confirm']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); 
    ?>
    
    <?= $form->field($model, 'confirm')->radioList(['1' => 'Подтверждем', '0' => 'Не подтвержден', '2'=> 'Отмена'])->label(false) ?>

    <div class="form-group">
        <?php 
        echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ///echo Html::submitButton('Update', ['btn btn-primary'])
           // Html::a('Update', ['updateconfirm', 'id' => $model->idpaymenti], ['class' => 'btn btn-primary']) 
            ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
</div>
