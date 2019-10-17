<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

//use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Requests */

$this->title = 'Update Request status: ' . $modelRequests->idrequest;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelRequests->idrequest, 'url' => ['view', 'id' => $modelRequests->idrequest]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="requests-updatestatus">
    <div class="requests-formupdatestatus">
        <div class="row">
            <div class="col-lg-6">

<?php $form = ActiveForm::begin([
        'id' => 'update-status',
        'action' => Url::to(['requests/updatestatus', 'idrequest' => $modelRequests->idrequest]),
    ]);?>
    <?= $form->field($modelRequests, 'status')->dropDownList($modelRequests::getStatusesArray()) ?>
    <?= $form->field($modelRequests, 'note')->textInput(['maxlength' => 164]) ?>
    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
