<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = 'Создать получение';
$this->params['breadcrumbs'][] = ['label' => 'Добавление получения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="receipt-create">

    <div class="receipt-form col-lg-4">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($modelReceipt, 'quantity')->textInput() ?>

        <?= $form->field($modelReceipt, 'date_receive')->widget(
                DatePicker::className(), [
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]
            );
        ?>

        <div class="form-group">
            <?= Html::submitButton($modelReceipt->isNewRecord ? 'Create' : 'Update', ['class' => $modelReceipt->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>