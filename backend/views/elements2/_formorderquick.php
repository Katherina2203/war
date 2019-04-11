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
<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#new_quickorder").on("pjax:end", function() {
            $.pjax.reload({container:"#requests"});  //Reload GridView
        });
    });'
    );
?>


<div class="requests-form">
<?php Pjax::begin(['id' => 'new_quickorder']) ?>
    <?php $form = ActiveForm::begin(
         //   ['options' => ['data-pjax' => true]]
            );
    
        $themes = Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->where(['status' => 'active'])->column();
        $suppliers = Supplier::find()->select(['name', 'idsupplier'])->indexBy('idsupplier')->column();
        $produces = Produce::find()->select(['manufacture', 'idpr'])->column();
        $category = Category::getHierarchy(); 
    ?>
   <div class="row">
  <div class="col-lg-6"> 
      
    <div class="box box-success">
      <div class="box-header">
         <h4 class="box-title pull-left">Обязательные поля для заявки</h4>
         <div class="clearfix"></div>
      </div>
    <div class="box-body">

   
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
        <?= $form->field($model, 'note')->textarea(['rows' => 2]) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div> 
 </div>
    
            </div>
   
  </div> 
    <?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
</div>

