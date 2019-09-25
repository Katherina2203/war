<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

use common\models\Currency;

?>

<?php
if (isset($modelRequests)) {
    $this->title = yii::t('app', 'Add request') . ' № ' . $modelRequests->idrequest;
} else {
    $this->title = yii::t('app', 'Edit account') . ' № ' . $modelAccounts->idord;
}
$this->params['breadcrumbs'][] = ['label' => 'Текущие счета', 'url' => ['paymentinvoice/index']];
$this->params['breadcrumbs'][] = ['label' => ('№ ' . $modelPaymentinvoice->invoice. ' от ' . $modelPaymentinvoice->date_invoice), 'url' => ['paymentinvoice/itemsin', 'idinvoice' => $modelPaymentinvoice->idpaymenti]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
    if (isset($providerAccountsForRequest) && $providerAccountsForRequest->getTotalCount()) {
        echo $this->render('_view_accounts', [
            'providerAccountsForRequest' => $providerAccountsForRequest,
            'modelRequests' => $modelRequests,
        ]);
    }
?>

<div class="accounts-create">
    <div class="row">
        <div class="col-md-6">
            <div class="addtoinvoice-form">
                <div class="box box-solid">
                    <div class="box-body">
                        
<?php $form = ActiveForm::begin(['id' => 'add-request',]); ?>
                        
    <?php echo $form->field($modelAccounts, 'idinvoice', ['template' => '{input}',])->input('hidden'); ?>

    <label class="control-label">
    <?php
        if (isset($modelRequests)) {
            echo 'Add the request № ' . $modelRequests->idrequest . ' to ';
        } else {
            echo 'Edit the account № ' . $modelAccounts->idord . ' of ';
        }
        echo  'the invoice № ' . $modelPaymentinvoice->invoice . ' of ' . $modelPaymentinvoice->date_invoice ;
    ?></label>
    <div class="form-group" ><b>Supplier: </b><?= $modelPaymentinvoice->supplier->name ;?></div>
    <div class="row" >
        <div class="col-sm-3" style="width: auto; padding-right: 5px;">Element (ID</div>
        <div class="col-sm-2" style="width: 60px; padding: 0px;">
            <?php echo $form->field($modelAccounts, 'idelem', ['template' => '{input}',])->textInput(['maxlength' => 6,]);?>
        </div>
        <div class="col-sm-7" style="width: auto; padding-left: 5px;">): 
            <?php 
            $sElementName = '';
            $sElementDescription = '';
            if (isset($modelRequests)) {
                $sElementName = $modelRequests->name;
                $sElementDescription = $modelRequests->description;
            } elseif (!is_null($modelAccounts->elements)) {
                $sElementName = $modelAccounts->elements->name;
                $sElementDescription = $modelAccounts->elements->nominal;
            }
            echo '<b>' . $sElementName . '</b>' . ", " . $sElementDescription;
            ?>
        </div>
    </div>
        
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
    
    <div class="row">
        <div class="col-sm-4"><?= $form->field($modelAccounts, 'sorting')->textInput(['maxlength' => true]) ?></div>
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