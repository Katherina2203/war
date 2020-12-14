<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Receipt */
/* @var $form yii\widgets\ActiveForm */
//$this->title = 'Товар в счете';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['receipt']];
$this->params['breadcrumbs'][] = $this->title;
?>
$this->title = $model->idord;
<div class="receipt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

  
    
    <?= $form->field($model, 'date_receive')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
        ]
        ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
