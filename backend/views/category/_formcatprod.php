<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use kartik\select2\Select2;
use yii\widgets\Pjax;

use common\models\Produce;
use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
$category = Category::find()->select(['name', 'idcategory'])->indexBy('idcategory')->column();//->where(["parent=:parent", ":parent" => $model->idcategory]);//common\models\Category::find()->select(['name', 'idcategory'])->indexBy('idcategory')->column();
$produce = Produce::find()->select(['manufacture', 'idpr'])->indexBy('idpr')->column();
?>

<div class="category-form">
<?php Pjax::begin(['id' => 'new_category_produce']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'idcategory')->textInput(['disabled' => true])
       /*     ->widget(Select2::className(),[
                    'data' => $category,
                    'options' => ['placeholder' => 'Выберите категорию '],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);*/?>

            <?= $form->field($model, 'idproduce')->widget(Select2::classname(),[
                           'data' => $produce,
                           'options' => ['placeholder' => 'Выберите производителя '],
                               'pluginOptions' => [
                                   'allowClear' => true
                               ],
                           ]);?> 
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
</div>
