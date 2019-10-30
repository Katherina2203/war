<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use common\models\Category;

$aCategories = Category::find()->select(['name', 'idcategory'])->from('category')->where('parent = 0')->orderBy('name')->indexBy('idcategory')->column();
$aCategories = ['0' => 'Сделать родительской директорией'] + $aCategories;
?>
<div class="category-form">
    <?php $form = ActiveForm::begin(['id' => $model->formName(),]); ?>
    <?= $form->field($model, 'parent')->widget(Select2::className(),[
            'data' => $aCategories,
            'options' => ['placeholder' => 'Выберите родительскую категорию'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
