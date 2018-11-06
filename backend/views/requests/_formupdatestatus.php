<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model common\models\Requests */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#update_request_status").on("pjax:end", function() {
            $.pjax.reload({container:"#produces"});  //Reload GridView
        });
    });'
    );
?>

<div class="requests-formupdatestatus">
    <div class="row">
        <div class="col-lg-6">
          
            
        <?php Pjax::begin(['id' => 'update_request_status']) ?>
            <?php $form = ActiveForm::begin([
                    'options' => ['enctype'=>'multipart/form-data'],
                         'enableAjaxValidation'=>true,
                     //   ['data-pjax' => true], 
                       //  'layout' => 'horizontal'
                     ]);
            ?>
                <?= $form->field($model, 'status')->radioList([ '0' => 'не  активна', '1' => 'Активна', '2' => 'Отмена', '3' => 'Выполнено'])?> 
                <div class="form-group">
                        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
  
        </div>
    </div>
</div>


