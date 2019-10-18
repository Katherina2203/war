<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;


use common\models\Themes;
use common\models\Themeunits;
use common\models\Boards;
use common\models\Users;

?>

<div class="elements-createfromstock-form col-lg-6">

    <?php
        $form = ActiveForm::begin([
            'id'=>$model->formName(),
            'enableClientValidation'=> true,
            'fieldConfig' => ['template' => '{label}{input}{hint}'],
        ]);

        //themes/projects
        $themes = Themes::find()->where(['status' => 'active'])->all();
        $themeList = ArrayHelper::map($themes,'idtheme', 'name');

        //units
        if (!is_null($model->idtheme)) {
            $units = Themeunits::find()->where(['idtheme' => $model->idtheme])->andWhere(['status' => 'active'])->all();
            $unitsList = ArrayHelper::map($units, 'idunit', 'nameunit');
        } else {
            $unitsList = [];
        }

        //boards
        if (!is_null($model->idthemeunit)) {
            $boards = Boards::find()->where(['idthemeunit' => $model->idthemeunit])->andWhere(['discontinued' => '1'])->all();
            $boardsList = ArrayHelper::map($boards, 'idboards', 'BoardnameId');
        } else {
            $boardsList = [];
        }
    ?>

    <?= $form->field($model, 'quantity')->textInput(['style'=>'width:150px']); ?>

    <?= $form->field($model, 'idtheme')->dropDownList($themeList, ['id' => 'idtheme']); ?>

    <?= $form->field($model, 'idthemeunit')->widget(DepDrop::classname(), [
            'data' => $unitsList,
            'options' => ['id' => 'idthemeunit'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['idtheme'],
                'initialize' => true,
                'initDepends' => [Html::getInputId($model, 'idtheme')],
                'placeholder' => yii::t('app', 'Выберите модуль проекта...'),
                'url' => Url::to(['/outofstock/themeunit']),
            ],
        ]);
    ?>

    <?= $form->field($model, 'idboart')->widget(DepDrop::classname(), [
            'data' => $boardsList,
            'options' => ['id' => 'idboart'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['idthemeunit'],
                'initialize' => true,
                'initDepends' => [Html::getInputId($model, 'idthemeunit')],
                'placeholder' => 'Выберите плату...',
                'url' => Url::to(['/outofstock/board']),
            ],
        ]);
    ?>
    
    <?= $form->field($model, 'ref_of_board')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
            'options' => ['value' => date("Y-m-d H:i:s"),], 
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ]
        ]);
    ?>
    <?php
        if (isset($update) && $update) {
            echo $form->field($model, 'idelement')->textInput(['style' => 'width:100px']);
        } else {
            echo $form->field($model, 'idelement')->textInput(['style' => 'width:100px', 'disabled' => true]);
        }
    ?>
    <?= $form->field($model, 'iduser')->dropDownList(
            ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Select Person']
        );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php 
        ActiveForm::end();
    ?>

<?php // update datas  in selected fields
    $this->registerJs(
        '$("document").ready(function() {
            // Child # 1 themeunit
            $("#outofstock-idthemeunit").depdrop({
                url: "/outofstock/themeunit",
                depends: ["idtheme"]
            });

            // Child # 2 boards
            $("#outofstock-idboart").depdrop({
                url: "/outofstock/board",
                depends: [["idthemeunit"]],
            });
        });'
    );
?>
</div>
