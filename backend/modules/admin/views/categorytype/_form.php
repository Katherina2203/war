<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=// $form->field($model, 'idtype_of_products')->textInput() 
        $form->field($model, 'idtype_of_products')->dropDownList(ArrayHelper::map(Category::find()->all(), 'idcategory', 'name')) ; ?>    
       

    <?= $form->field($model, 'idcategory')->dropDownList(ArrayHelper::map(Category::find()->all(), 'idcategory', 'name')) ; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
