<?php
use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\ActiveForm;
?>


<?= Alert::widget() ?>

<?php $form = ActiveForm::begin(); ?>

  <?= $form->field($user, 'email')->textInput() ?>

<div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton('Submit',['class' => 'btn btn-primary']);?>
    </div>
</div>

 <?php ActiveForm::end(); ?>