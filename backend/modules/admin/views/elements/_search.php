<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\elementsSearch */
/* @var $form yii\widgets\ActiveForm */
use common\models\Category;
$getcategory = Category::getHierarchy(); //ArrayHelper::map(common\models\Category::find()->select(['name_ru', 'idcategory'])->all(), 'idcategory', 'name_ru');
$getproduce = ArrayHelper::map(common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture');
?>

<div class="elements-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'nominal') ?>
    
    <?= $form->field($model, 'idcategory')->dropDownList($getcategory,
            ['prompt'=>'Выберите категорию'])?>

    <?php  echo $form->field($model, 'idproduce')->dropDownList($getproduce,
            ['prompt'=>'Выберите производителя']) ?>

    <?php // echo $form->field($model, 'idcategory') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script> 
$(document).ready(function () {
$('.elements-search').val("");
});
</script>