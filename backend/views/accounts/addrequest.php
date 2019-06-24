<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

use common\models\Currency;
/* @var $model common\models\Accounts */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    
$this->title = yii::t('app', 'Add request') . ' № ' . $modelRequests->idrequest;
$this->params['breadcrumbs'][] = ['label' => 'Текущие счета', 'url' => ['paymentinvoice/index']];
$this->params['breadcrumbs'][] = ['label' => ('№ ' . $modelPaymentinvoice->invoice. ' от ' . $modelPaymentinvoice->date_invoice), 'url' => ['paymentinvoice/itemsin', 'idinvoice' => $modelPaymentinvoice->idpaymenti]];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="accounts-create">
    <div class="row">
        <div class="col-md-6">
            <div class="addtoinvoice-form">
                <div class="box box-solid">
                    <div class="box-body">
                        
<?php $form = ActiveForm::begin(['id' => 'add-request',]); ?>
                        
    <?php echo $form->field($modelAccounts, 'idinvoice', ['template' => '{input}',])->input('hidden'); ?>
    <?php echo $form->field($modelAccounts, 'idelem', ['template' => '{input}',])->input('hidden'); ?>
    <label class="control-label"><?= 'Add the request №' . $modelRequests->idrequest . ' to the invoice №' . $modelPaymentinvoice->invoice . ' of ' . $modelPaymentinvoice->date_invoice ;?></label>
    <div class="form-group" ><b>Supplier: </b><?= $modelPaymentinvoice->supplier->name ;?></div>
    <div class="form-group" ><?= 'Element (ID ' . $modelRequests->estimated_idel . "): " . '<b>' . $modelRequests->name . '</b>' . ", " . $modelRequests->description ?></div>
        
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($modelPrices, 'idcurrency')->dropDownList(Currency::find()->select(['currency', 'idcurrency'])->indexBy('idcurrency')->column(), ['prompt'=> yii::t('app', 'Select currency')]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelPrices, 'pdv')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelPrices, 'usd')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row" >
        <div class="col-sm-6"><?= $form->field($modelPrices, 'unitPrice')->textInput(['maxlength' => true, 'placeholder' => 'Цена за единицу товара']) ?></div> 
        <div class="col-sm-6"><?= $form->field($modelPrices, 'forUP')->textInput(['maxlength' => true]) ?></div>
    </div>
    
    <div class="row" >
        <div class="col-sm-6"><?= $form->field($modelAccounts, 'quantity')->textInput(['maxlength' => true]) ?></div> 
        <div class="col-sm-6"><?= $form->field($modelAccounts, 'amount')->textInput(['maxlength' => true]) ?></div>
    </div>
    
    <div class="row">
        <div class="col-sm-6"><?= $form->field($modelAccounts, 'delivery')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6">
            <?= $form->field($modelAccounts, 'date_receive')->widget(
                DatePicker::className(), [
                    'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);?>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>
                        
<?php ActiveForm::end(); ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>