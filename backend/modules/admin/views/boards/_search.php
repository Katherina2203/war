<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\BoardsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="boards-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'idboards') ?>

    <?= $form->field($model, 'idtheme')->dropDownList(ArrayHelper::map(common\models\Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),
            ['prompt'=>'Выберите проект'])  ?>

    <?= $form->field($model, 'idthemeunit')->dropDownList(ArrayHelper::map(common\models\Themeunits::find()->select(['nameunit', 'idunit'])->all(), 'idunit', 'nameunit'),
            ['prompt'=>'Выберите модуль'])  ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'current')->dropDownList(ArrayHelper::map(common\models\Users::find()->select(['surname', 'id'])->where(yii::$app->user->can('engineer'))->all(), 'id', 'surname'),
            ['prompt'=>'Выберите ответственного'])  ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'discontinued') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
