<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
//use dosamigos\datepicker\DatePicker;
//use yii\helpers\ArrayHelper;
//use yii\widgets\Pjax;
//use kartik\select2\Select2;

use common\models\Users;

//
//use yii\helpers\Url;
//use kartik\depdrop\DepDrop;

?>
<?php
$this->title = 'Взять со склада быстро';
$this->params['breadcrumbs'][] = ['label' => $modelElements->name . ', ' . $modelElements->nominal, 'url' => ['elements/viewfrom', 'idel' => $modelElements->idelements]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fromquick-create">
    <div class="fromquick-form col-md-4">
        <div class="box box-success">
            <div class="box-header with-border"><h2 class="box-title"><?= $modelElements->name ?></h2></div>
            <div class="box-header with-border"><?= $modelElements->nominal ?></div>
            <div class="box-body">
            <?php $form = ActiveForm::begin(['id' => 'create-from-quick',]); ?>
                <?php echo $form->field($modelOutofstock, 'idelement', ['template' => '{input}',])->input('hidden'); ?>
                <?= $form->field($modelOutofstock, 'quantity')->textInput() ?>
                <?= $form->field($modelOutofstock, 'idboart')->textInput()->input('text', ['placeholder' => "Enter # board"]);?>
                <?= $form->field($modelOutofstock, 'ref_of_board')->textInput() ?>
                <div class="form-group">
                  <?= Html::submitButton($modelOutofstock->isNewRecord ? 'Create' : 'Update', ['class' => $modelOutofstock->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
