<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\widgets\ActiveForm;
//use kartik\widgets\FileInput;
use dosamigos\datepicker\DatePicker;

//use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Elements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requestsquick-form">

    <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()
                ->select(['name', 'idtheme'])
                ->where(['status' => 'active']) 
            //    ->with('themeunits')
                ->all(),
                'idtheme', 
                'name'),['prompt'=>'Выберете проект']); ?>

            <?= $form->field($model, 'quantity')->textInput() ?>
          
             <?= $form->field($model, 'required_date')->widget(
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
