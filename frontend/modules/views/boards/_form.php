<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\Users;
use common\models\Themes;
use common\models\Themeunits;
/* @var $this yii\web\View */
/* @var $model common\models\Boards */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="boards-form col-lg-6">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]);
        $themes = Themes::find()->where(['status' => 'active'])->all();
        $themeList = ArrayHelper::map($themes,'idtheme', 'name');
    ?>

    <?= $form->field($model, 'idtheme')->dropDownList($themeList, ['id' => 'idtheme']); ?>

    <?= $form->field($model, 'idthemeunit')->widget(DepDrop::classname(), [
        'options'=>['id'=>'idunit'],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
              'depends'=>['idtheme'],
              'placeholder'=>'Выберите модуль проекта...',
              'url'=>Url::to(['/outofstock/themeunit'])
           ]
        ]);?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'current')->dropDownList(Users::find()->select(['surname', 'id'])->column(),    ['prompt'=>'Выберите ответственного']) ?>

    <?= //$form->field($model, 'date_added')->textInput() 
        $form->field($model, 'date_added')->widget(
        DatePicker::className(), [
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
         //   'inputWidth'=>'200px'
        ]
        ]);
    ?>

    <?= $form->field($model, 'discontinued')->radioList([ 1 => 'Актуально', 0 => 'Закрыто', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
