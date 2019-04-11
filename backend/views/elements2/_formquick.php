<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
//use kartik\widgets\ActiveForm;
//use kartik\widgets\FileInput;
use dosamigos\datepicker\DatePicker;

//use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Elements */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="requestquick-form">
<?php Pjax::begin(['id' => 'quickorder']); ?>
    <?php $form = ActiveForm::begin(
            ['options' => ['data-pjax' => true]]
            ); ?>
            <?= $form->field($model, 'idproject')->dropDownList(ArrayHelper::map(common\models\Themes::find()
                ->select(['name', 'idtheme'])
                ->where(['status' => 'active']) 
            //    ->with('themeunits')
                ->all(),
                'idtheme', 
                'name'),['prompt'=>'Выберете проект']); ?>
    
            <?= $form->field($model, 'idboard')->textInput()->input('№ платы', ['placeholder' => "Enter number pcb"])->label(false)?>

            <?= $form->field($model, 'quantity')->textInput() ?>
          
          
            <?= $form->field($model, 'required_date')->widget(
                    DatePicker::className(), [
                        'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                  ]); ?>
    
            <?= $form->field($model, 'note')->textarea(['rows' => 2]) ?>
    
            <?= $form->field($model, 'iduser')->dropDownList(ArrayHelper::map(\common\models\Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
            ['prompt'=>'Выберите Заказчика']) ?>
        <div class="form-group">
            <?= 
                Html::submitButton($model->isNewRecord ? 'Create' : 'Create', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])      
                     /*     Html::a('<i class="glyphicon glyphicon-list"></i>Заказать', 
                                ['orderquick', 'iduser' => yii::$app->user->identity->id, 'idel' => $modelel->idelements], 
                                [ 'title'=>'Создать заявку этого товара', 'class' => 'btn btn-warning'])*/
                        ?>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
</div>
