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
        'action' => ['byexecutor'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'idrequest') ?>

    <?php // $form->field($model, 'iduser') ?>
  

    <?= $form->field($modelrequest, 'name') ?>
    
    <?= $form->field($modelrequest, 'description') ?>

    <?= $form->field($modelrequest, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),
            ['prompt'=>'Выберите проект'])  ?>
    
    <?php // $form->field($model, 'idproduce')->dropDownList(ArrayHelper::map(common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture'),   ['prompt'=>'Выберите производителя']); ?>

    

    <?php // echo $form->field($model, 'idproject') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
