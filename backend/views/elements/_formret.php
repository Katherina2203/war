<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\Users;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Returnitem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="returnitem-form">

  <div class="col-md-4">
    <?php $form = ActiveForm::begin(); ?>

  

    <?= $form->field($return, 'quantity')->textInput() ?>

    <?php // $form->field($return, 'date_return')->textInput() ?>

    <?php // $form->field($return, 'created_by')->textInput()
            //->dropDownList(ArrayHelper::map(Users::find()->select(['name', 'surname','id'])->all(), 'id', 'UserName'),
          //  ['prompt'=>'Select Person'])?>
    
     <?php // $form->field($return, 'idelement')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($return->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $return->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
