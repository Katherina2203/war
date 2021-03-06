<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;


use common\models\Themes;
use common\models\Supplier;
use common\models\Produce;
use common\models\Category;
use common\models\TypeRequest;
/* @var $this yii\web\View */
/* @var $model common\models\Requests */
/* @var $form yii\widgets\ActiveForm */
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
       'options' => ['enctype'=>'multipart/form-data'],
        //   ['data-pjax' => true], 
          //  'layout' => 'horizontal'
        ]);
        $themes = Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->where(['status' => 'active'])->column();
        $suppliers = Supplier::find()->select(['name', 'idsupplier'])->indexBy('idsupplier')->column();
        $produces = Produce::find()->select(['manufacture', 'idpr'])->column();
        $category = Category::getHierarchy(); 
    ?>
    
  <div class="col-lg-6"> 
       <?= $form->field($model, 'idtype')->radioList(ArrayHelper::map(TypeRequest::find()->all(), 'idtype', 'name'))?>
    <div class="box box-success">
      <div class="box-header">
         <h4 class="box-title pull-left">Обязательные поля для заявки</h4>
         <div class="clearfix"></div>
      </div>
    <div class="box-body">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3, 'cols' => 5]) ?>
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
    
            </div>
    <div class="col-lg-6">
      <div class="box box-warning">
       <div class="box-header">
           <h4 class="box-title pull-left">Необязательные поля для заявки</h4>
           <div class="clearfix"></div>
       </div>
      <div class="box-body"> 
        
        <?php Pjax::begin(['id' => 'List']) ?>
            <?= $form->field($model, 'idsupplier')->widget(Select2::className(), [
                'data' => $suppliers,
                'options' => ['id' => 'idsupplier', 'placeholder' => Yii::t('app', 'Выберите поставщика')],
                    'pluginOptions' => [
                        'allowClear' => true,
                      
                    ],
               
                  
            ]);?>
          <?php echo Html::button('+', ['value' => Url::to('index.php?r=requests/createsupplier'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
        <?php Pjax::end() ?>
            <?php
                Modal::begin([
                        
                        'id' => 'modal',
                        'size' => 'modal-md',
                        'options' => [
                          // 'id' => 'kartik-modal',
                           'tabindex' => false // important for Select2 to work properly
                        ],
                       'header' => '<h4>New supplier</h4>',
                    ]);
               // echo "<div id='modalContent'></div>";
                echo '<div id="modalContent">'.    $form->field($model, 'idsupplier')->textInput(['maxlength' => true]);
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']).'</div>';
                Modal::end();
            ?>
         
        <?php Pjax::begin(['id' => 'List']) ?>
            <?=   $form->field($model, 'idproduce')->widget(Select2::className(), [
                'data' => $produces,
                'options' => ['placeholder' => 'Выберите производителя '],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
            ]);?>
          <?= Html::button('+', ['value' => Url::to('requests/createproduce'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
        <?php Pjax::end() ?>
          
            <?php
                Modal::begin([
                        'header' => '<h4>New produce</h4>',
                        'id' => 'modal',
                        'size' => 'modal-md',
                    ]);
                echo '<div id="modalContent">'.  $form->field($model, 'idproduce')->textInput(['maxlength' => true]);
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']).'</div>';
                Modal::end();
            ?>

        <?= $form->field($model, 'img') ->widget(FileInput::classname(), [
                                         'options' => ['accept' => 'images/requests/*'],
                             ]);  ?>

        <?= $form->field($model, 'note')->textarea(['rows' => 2, 'cols' => 5]) ?>

        <?= $form->field($model, 'estimated_executor')->dropDownList(ArrayHelper::map(\common\models\Users::find()->select(['name', 'surname','id'])->where(['role' => '2'])->all(), 'id', 'UserName'),
            ['prompt'=>'Выберите Предполагаемого исполнителя']) ?>
        
        <?= $form->field($model, 'estimated_category')->widget(Select2::className(),[
            'data' => $category,
            'options' => ['placeholder' => 'Выберите категорию '],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>
    
        <?= $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(\common\models\Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Выберите Заказчика']) ?>
       </div> 
      </div>   
    </div> 
 
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
</div>

<?php

$script = <<< JS
    

        
$('form#{$model->formName()}').on('beforeSubmit', function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), // serialize yii2 form
        \$form.serialize()
    )
        .done(function(result) {
        if(result == 1)
        {
            $(document).find('#modal').modal('hide');
            $.pjax.reload({container:'#List'});
            $(document).on('pjax:complete', function() {
              $('#idproduce option:last-child').attr('selected', true);
            })
        }else
        {
            $(\$form).trigger("reset");
            $("#message").html(result.message);
        }
        }).fail(function()
        {
            console.log("server error");
        });
    return false;
});

JS;

$this->registerJs($script);

?>
