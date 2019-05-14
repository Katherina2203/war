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

    <?php $form = ActiveForm::begin(['id'=>$modelout->formName(),
                                     'enableClientValidation'=> true,
                                     'fieldConfig' => ['template' => '{label}{input}{hint}']
        ]); 
  
    ?>

    <?= $form->field($modelout, 'quantity')->textInput(['style'=>'width:150px']) ?>

    <?= 
            
         // VarDumper::dump($modelout->boards->idtheme);   
            $form->field($modelout, 'idtheme')->textInput(); ?>

    <?=    
            $form->field($modelout, 'idthemeunit')->textInput(); ?>

    <?= $form->field($modelout, 'idboart')->textInput(['disabled' => true]);  ?>
    
    <?= $form->field($modelout, 'ref_of_board')->textInput() ?>
    
    <?= //$form->field($model, 'date')->textInput() 
        $form->field($modelout, 'date')->widget(DatePicker::className(), [
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
    
    <?= $form->field($modelout, 'idelement')->textInput(['style'=>'width:100px', 'disabled' => true]) ?>

    <?=
        $form->field($modelout, 'iduser')->dropDownList(ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Select Person'])  
    ?>

    
    <div class="form-group">
        <?= Html::submitButton($modelout->isNewRecord ? 'Create' : 'Update', ['class' => $modelout->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


   <?php ActiveForm::end(); ?>

<?php // update datas  in selected fields
    $this->registerJs(
        '$("document").ready(function() {
            
        // Child # 1 themeunit
        $("#outofstock-idthemeunit").depdrop({
            url: "/outofstock/themeunit",
            depends: ["idtheme"]
        });

        // Child # 2 boards
        $("#outofstock-idboart").depdrop({
            url: "/outofstock/board",
            depends: ["idthemeunit"],
          
        });
        

    

        });'
    );
?>

</div>
