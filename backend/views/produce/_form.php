<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Produce */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#new_produce").on("pjax:end", function() {
            $.pjax.reload({container:"#produces"});  //Reload GridView
        });
    });'
    );
?>
<div class="produce-form">
<?php Pjax::begin(['id' => 'new_produce']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

        <?= $form->field($model, 'manufacture')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
