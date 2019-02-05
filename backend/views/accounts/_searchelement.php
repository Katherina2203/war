<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\elementsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elements-search">

    <?php $form = ActiveForm::begin([
        
        'action' => ['index'],
        'method' => 'get',
        'attributes' => ['name', 'nominal'], 
    ]); ?>

    <?= $form->field($modelelem, 'name') ?>

    <?= $form->field($modelelem, 'nominal') ?>
    
    <?= $form->field($modelelem, 'idcategory')->dropDownList(ArrayHelper::map(common\models\Category::find()->select(['name_ru', 'idcategory'])->all(), 'idcategory', 'name_ru'),
            ['prompt'=>'Выберите категорию'])?>

    <?php  echo $form->field($modelelem, 'idproduce')->dropDownList(ArrayHelper::map(common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture'),
            ['prompt'=>'Выберите производителя']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
