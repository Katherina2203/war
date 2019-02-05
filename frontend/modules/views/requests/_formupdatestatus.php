<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model common\models\Requests */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="requests-formupdatestatus">
<?php Pjax::begin(['id' => 'new_request']) ?>
    <?php $form = ActiveForm::begin([
       'options' => ['enctype'=>'multipart/form-data'],
            'enableAjaxValidation'=>true,
        //   ['data-pjax' => true], 
          //  'layout' => 'horizontal'
        ]);
  
    ?>
    <div class="col-lg-6"> 

    <div class="box box-success">
  
    <div class="box-body">
  <?= $form->field($model, 'status')->radioList([ '0' => 'не  активна', '1' => 'Активна', '2' => 'Отмена', '3' => 'Выполнено']
          )?> 

    
    <?php // $form->field($model, 'status')->dropDownList([ '0' => 'не  активна', '1' => 'Активна', '2' => 'Отмена', '3' => 'Выполнено'], ['prompt' => '']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div> 
   </div>
</div>
  
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
</div>


