<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
//use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\Users;
/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="processingrequest-form">
    <span>Укажите исполнителя заявки</span>
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
     <?php // $form->field($model, 'idresponsive')->dropDownList(Users::find()->select(['name', 'surname','id'])->where(['id' => 33])->indexBy('id')->column(), 
   // ['prompt'=>'']); 
            ?>

    <?php //echo $form->field($model, 'idrequest')->textInput(['style'=>'width:100px'])?>
    
    <?= $form->field($model, 'idpurchasegroup')->radioList(ArrayHelper::map(\common\models\Users::find()->select(['surname','id'])->where(['role' => '2'])->all(), 'id', 'surname'),
            ['prompt'=>'Select Person']) 
            ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div>
    <?php  if(isset($model->idrequest)){ ?>
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idprocessing',
            'idpurchasegroup',
            'idresponsive',
            'idrequest',
            'created_at',
         //   'updated_at',
            
        ],
    ]) ?>
    <?php }?>
     
</div>


