<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\models\RequestsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
  
<div class="row">
    <div class="col col-md-4">
        <?= $form->field($model, 'name') ?>
    </div>
    <div class="col col-md-4">
        <?= $form->field($model, 'description') ?>
    </div>
    <div class="col col-md-3">
        <?= $form->field($model, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),
            ['prompt'=>'Выберите проект'])  ?>
    </div>
</div> 
    <?php // $form->field($model, 'idproduce')->dropDownList(ArrayHelper::map(common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture'),   ['prompt'=>'Выберите производителя']); ?>
    <?php // echo $form->field($model, 'idproject') ?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
