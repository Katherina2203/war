<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;


use common\models\Themes;
use common\models\Themeunits;
use common\models\Boards;
use common\models\Users;
/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elements-createfromstock-form col-lg-6">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),
                                     'enableClientValidation'=> true,
                                     'fieldConfig' => ['template' => '{label}{input}{hint}']
        ]); 

         ?>

    <?= $form->field($model, 'quantity')->textInput(['style'=>'width:150px']) ?>

    
    
    
    <?= //$form->field($model, 'date')->textInput() 
        $form->field($model, 'date')->widget(DatePicker::className(), [
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

    <?=
        $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Select Person'])  
    ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


   <?php ActiveForm::end(); ?>



</div>
