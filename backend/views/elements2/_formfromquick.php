<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\widgets\ActiveForm;
//use kartik\widgets\FileInput;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;


use common\models\Users;
//use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Elements */
/* @var $form yii\widgets\ActiveForm */
$boards = common\models\Boards::find()->select(['name', 'idboards'])->indexBy('idboards')->where(['discontinued' => '1'])->column();
?>

<div class="fromquick-form col-md-4">
     <div class="box box-success">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'quantity')->textInput() ?>
            <?= $form->field($model, 'idboart')->textInput()->input('board', ['placeholder' => "Enter # board"]);?>
                <?php /* $form->field($model, 'idboart')->dropDownList(ArrayHelper::map(common\models\Boards::find()
                    ->select(['name', 'idboards'])
                    ->where(['discontinued' => '1']) 
                //    ->with('themeunits')
                    ->all(),
                    'idboards', 
                    'name'),['prompt'=>'Выберете плату']); */
                ?>



                <?= $form->field($model, 'ref_of_board')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'date')->widget(DatePicker::className(), [
                                                'options' => [ 
                                                    'value' => date("Y-m-d H:i:s"), 
                                                   // 'disabled' => 'disabled',
                                                ], 
                                                    'clientOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy-mm-dd',
                                                        'todayHighlight' => true,

                                            ]
                ]);?>
    
                 <?= $form->field($model, 'idelement')->textInput(['style'=>'width:100px', 'disabled' => true]) ?>

                <?= $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Select Person']);?>
    
            <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
     </div>
</div>

