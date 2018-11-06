<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Requests */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requests-form">

    <?php $form = ActiveForm::begin(); ?>

 
<div class="col-sm-6">
    <span style="margin-bottom: 15px">Обязательные поля для заявки</span>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2, 'cols' => 5]) ?>
    
    <?= $form->field($model, 'quantity')->textInput(['style' => 'width: 100px;']) ?>
    
    <?= $form->field($model, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()
                ->select(['name', 'idtheme'])
                ->where(['status' => 'active']) 
            //    ->with('themeunits')
                ->all(),
                'idtheme', 
                'name'),['prompt'=>'Выберете проект']);?>
    
    <?=$form->field($model, 'required_date')->widget(
                    DatePicker::className(), [
                     'clientOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy-mm-dd'
        ]
        ]);?>
    
    <?= $form->field($model, 'status')->dropDownList([ 0 => 'актуально'], ['prompt' => '']) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<div class="col-sm-6"> 
    <span style="margin-bottom: 15px">Не обязательные поля для заявки</span>
    <?= $form->field($model, 'idsupplier')->dropDownList(ArrayHelper::map(\common\models\Supplier::find()->select(['name', 'idsupplier'])->all(), 'idsupplier', 'name'),
            ['prompt'=>'Выберете поставщика']); ?>
    
    <?=   $form->field($model, 'idproduce')->dropDownList(ArrayHelper::map(\common\models\Produce::find()->select(['manufacture', 'idpr'])->all(), 'idpr', 'manufacture'),
            ['prompt'=>'Выберете производителя']); ?>

    
   

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['rows' => 3]) ?>

</div> 
    
    <?php // $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(\common\models\Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
          //  ['prompt'=>'Выберите Заказчика']) ?>

    

    <?php ActiveForm::end(); ?>

</div>

