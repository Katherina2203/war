<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outofstock-form">

    <?php $form = ActiveForm::begin(); 
           ?>

    <?= $form->field( $model , 'idelement')->textInput()->label(false) ?>

  
    <?= $form->field($model, 'quantity')->textInput()->label(false) ?>

  

    
    <?= $form->field($model, 'ref_of_board')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
