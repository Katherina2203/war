<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\ProcessingrequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="processingrequest-searchreq">

    <?php $form = ActiveForm::begin([
        'action' => ['executors', ], 
        'method' => 'get',
    ]); ?>

    <?= $form->field($modelRequest, 'name') ?>
    
    <?php echo $form->field($modelRequest, 'description') ?>
    
    <?= $form->field($modelRequest, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),
            ['prompt'=>'Выберите проект'])  ?>

    <?php // $form->field($model, 'idpayer') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
