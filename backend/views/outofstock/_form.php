<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use yii\helpers\Json;
//use kartik\select2\Select2;

use common\models\Themes;
use common\models\Themeunits;
use common\models\Boards;
use common\models\Users;
/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outofstock-form col-lg-6">

    <?php $form = ActiveForm::begin(); 
        //themes/projects
        $themes = Themes::find()->where(['status' => 'active'])->all();
        $themeList = ArrayHelper::map($themes,'idtheme', 'name');
        //units
        $units = Themeunits::find()->all();
        $unitsList = ArrayHelper::map($units, 'idunit', 'nameunit');
        //boards
        $boards = Boards::find()->where(['discontinued' => '1'])->all();
        $boardsList = ArrayHelper::map($boards, 'idboards', 'BoardnameId');
         ?>

    <?= $form->field($model, 'idelement')->textInput(['style'=>'width:100px']) ?>

    

    <?= $form->field($model, 'quantity')->textInput(['style'=>'width:150px']) ?>

   
    
    <?= $form->field($model, 'idtheme')->dropDownList($themeList, ['id' => 'idtheme']); ?>

    <?= /*input themeunits depentend only on idtheme */
        $form->field($model, 'idthemeunit')->widget(DepDrop::classname(), [
                                                    'options' => ['id'=>'idunit'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'select2Options' => ['pluginOptions'=>['allowClear'=>true]],
                                                    'pluginOptions' => [
                                                            'depends'=>['idtheme'],
                                                            'placeholder' => 'Выберите модуль проекта...',
                                                            'url' => Url::to(['/outofstock/themeunit'])
                                                       ]
        ]);?>

    <?=  /* display boards depentend only on idtheme and idthemeunit */ 
        $form->field($model, 'idboart')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                    'pluginOptions' => [
                                                            'depends' => ['idthemeunit'],
                                                            'initDepends' => ['idtheme'],
                                                            'initialize' => true,
                                                            'placeholder' => 'Выберите плату...',
                                                            'url' => Url::to(['/outofstock/board']),
                                                            ]
                                                    ]);
        // $form->field($model, 'idboart')->dropDownList($boardsList, ['id' => 'idboards']);
    ?>
       
    <?= $form->field($model, 'ref_of_board')->textInput(['maxlength' => true]) ?>
    
    <?= //$form->field($model, 'date')->textInput() 
        $form->field($model, 'date')->widget(DatePicker::className(), [
                                    'options' => [ 
                                        'value' => date("Y-m-d H:i:s"), 
                                        //'disabled' => 'disabled',
                                    ], 
                                    'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true,
                                       
                                    ]
        ]);?>

    <?= $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Select Person'])  ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<script>
    $(document).on('ready', function(ev) {
    // Child # 1 themeunit dependent only on idtheme
    $(".field-outofstock-idthemeunit").depdrop({
        depends: ['idtheme'],
        url: '/outofstock/themeunit'
    });
 
    // Child # 2 boards dependent only on idtheme, idthemunit
    $(".field-outofstock-idboart").depdrop({
        depends: ['idthemeunit'],
        initDepends: ['idtheme'],
        initialize: true,
        url: '/outofstock/board',
    });
    });
</script>

    <?php ActiveForm::end(); ?>

</div>
