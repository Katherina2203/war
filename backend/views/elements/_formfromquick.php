<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\widgets\ActiveForm;
//use kartik\widgets\FileInput;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
//use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Elements */
/* @var $form yii\widgets\ActiveForm */
$boards = common\models\Boards::find()->select(['name', 'idboards'])->indexBy('idboards')->where(['discontinued' => '1'])->column();
?>

<div class="fromquick-form col-md-6">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'idboart')->widget(Select2::className(), [
             'data' => $boards,
             'options' => ['placeholder' => 'Выберите плату '],
                'pluginOptions' => [
                    'allowClear' => true
                ],
        ]);?>
            <?php /* $form->field($model, 'idboart')->dropDownList(ArrayHelper::map(common\models\Boards::find()
                ->select(['name', 'idboards'])
                ->where(['discontinued' => '1']) 
            //    ->with('themeunits')
                ->all(),
                'idboards', 
                'name'),['prompt'=>'Выберете плату']); */
            ?>

            <?= $form->field($model, 'quantity')->textInput() ?>
          
             <?= $form->field($model, 'date')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
                    ]
                  ]); ?>
            <div class="form-group">
             <?= Html::submitButton($model->isNewRecord ? 'Update' : 'Create', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
          <?php ActiveForm::end(); ?>

</div>
