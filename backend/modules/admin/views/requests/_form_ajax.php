<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use kartik\file\FileInput;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\models\Themes;
use common\models\Supplier;
use common\models\Produce;
?>
<?php // обновляем грид под формой с оплатой внутри модального окна
    $this->registerJs(
        '$("document").ready(function(){
            $("#new_request").on("pjax:end", function() {
            $.pjax.reload({container:"#requests"});  //Reload GridView
        });
    });'
    );
?>

<div class="requests-form">
<?php Pjax::begin(['id' => 'new_request']) ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true], 
      //  'layout' => 'horizontal'
        ] );
        $themes = Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->where(['status' => 'active'])->column();
        $suppliers = Supplier::find()->select(['name', 'idsupplier'])->indexBy('idsupplier')->column();
        $produces = Produce::find()->select(['manufacture', 'idpr'])->column();
    ?>
    <div class="panel panel-default">
        <div class="col-lg-6"> 
<div class="panel-heading">
    <h4 class="panel-title pull-left">Обязательные поля для заявки</h4>
    <div class="clearfix"></div>
</div>
        
 <div class="panel-body">
     
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2, 'cols' => 5]) ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'quantity')->textInput()//['style' => 'width: 100px;'] ?>
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'idproject')->widget(Select2::className(), [
             'data' => $themes,
             'options' => ['placeholder' => 'Выберите проект '],
                'pluginOptions' => [
                'allowClear' => true
            ],
         ]);?>
        </div> 
    </div>
    
    <?=$form->field($model, 'required_date')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    
    <?php // $form->field($model, 'status')->dropDownList([ '0' => 'не  активна', '1' => 'Активна', '2' => 'Отмена', '3' => 'Выполнено'], ['prompt' => '']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
 </div>
    
            </div>
<div class="col-lg-6"> 
<div class="panel-heading">
    <h4 class="panel-title pull-left">Необязательные поля для заявки</h4>
    <div class="clearfix"></div>
</div>
    <div class="panel-body"> 
        
        <?= $form->field($model, 'idsupplier')->widget(Select2::className(), [
            'data' => $suppliers,
            'options' => ['placeholder' => 'Выберите поставщика '],
                'pluginOptions' => [
                'allowClear' => true
                ],
        ]);?>
    
        <?=   $form->field($model, 'idproduce')->widget(Select2::className(), [
            'data' => $produces,
            'options' => ['placeholder' => 'Выберите производителя '],
                'pluginOptions' => [
                    'allowClear' => true
                ],
        ]);?>

        <?= $form->field($model, 'img') ->widget(FileInput::classname(), [
                                         'options' => ['accept' => 'images/requests/*'],
                             ]);  ?>

        <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    
        <?= $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(\common\models\Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Выберите Заказчика']) ?>
    </div> 
         
  </div> 
 
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
</div>

