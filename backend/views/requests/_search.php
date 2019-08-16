<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\models\RequestsSearch */
/* @var $form yii\widgets\ActiveForm */
$getProject = ArrayHelper::map(\common\models\Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active'])->all(), 'idtheme', 'name');
?>

<div class="requests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'idrequest') ?>

   
    
    <?= $form->field($model, 'name')->textInput(['placeholder' => yii::t('app', 'Search by name')]) ?>
    
    <?= $form->field($model, 'description')->textInput(['placeholder' => yii::t('app', 'Search by description')]) ?>
    <div class="row">
        <div class="col col-md-4">
            <?= $form->field($model, 'idproject')->dropDownList($getProject,
                ['prompt'=> yii::t('app', 'Choose project')])  ?>
        </div>
        <div class="col col-md-4">
            <?= $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(common\models\Users::find()->select(['id', 'surname'])->all(), 'id', 'surname'),
                ['class'=>'form-control','prompt' => 'Выберите заказчика']) ?>
        </div>
    </div>
    <?php // $form->field($model, 'idproduce')->dropDownList(ArrayHelper::map(common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture'),   ['prompt'=>'Выберите производителя']); ?>

    <?php // echo $form->field($model, 'idproject') ?>
<div class="row">
    <div class="col col-md-4">
    <?= $form->field($model, 'idboard')->textInput(['placeholder' => yii::t('app', 'Search by id pcb')], ['prompt' => 'Выберите заказчика']) ?>
    </div>
  </div>
    
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script> 
$(document).ready(function () {
$('.requests-search').val("");
});
</script>