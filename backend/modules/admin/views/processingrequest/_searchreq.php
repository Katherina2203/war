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
        'action' => ['executors', ], //requests/index
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name') ?>
    
    <?php echo $form->field($model, 'description') ?>
    
    <?= $form->field($model, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),
            ['prompt'=>'Выберите проект'])  ?>

  

 

    <?php // $form->field($model, 'idpayer') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
