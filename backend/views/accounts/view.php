<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Accounts */

$this->title = $model->idord;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h2><?php echo $model->elements->name . ', ' . $model->elements->nominal?></h2>
<div class="accounts-view col-md-6">
  
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idord], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idord], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
      
        <?= Html::a('Поменять счет', ['changeinvoice'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Добавить товар в счет', ['create'], ['class' => 'btn btn-success']) ?>
        
    
    </p>
<div class="box">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idord',
            'idelem',
          //  'idprice',
            [
                
                    'attribute' =>  'idprice',
                    'format' => 'raw',
                    'value' => ArrayHelper::getValue($model, 'prices.price') . ' ' . ArrayHelper::getValue($model, 'prices.currency.currency'), 
            ],
            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$model->quantity.'</strong>', 
                'displayOnly'=>true,
               //  'inputContainer' => ['class'=>'col-sm-6'] 
            ],
            [
                'attribute' => 'idinvoice',
                'format' => 'raw',
                'value' => ArrayHelper::getValue($model, 'paymentinvoice.invoiceitem')
            ],
           // 'idinvoice',
         //   'account_date',
            'amount',
            'delivery',
            
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => $model->status == 2 ? '<span class="label label-warning">Заказано</span>' : '<span class="label label-success">На складе</span>',
                'widgetOptions'=>[
                        'pluginOptions'=>[
                            '2'=>'Заказано',
                            '3'=>'На складе',
                            '4'=>'Отмена',
                        ]
                ]
            ],
            'date_receive',
        ],
    ]) ?>
  </div>  
 </div>
   
    <div>
        Invoice
    </div>
    
</div>
