<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\detail\DetailView;
use yii\grid\GridView;
use backend\components\TotalColumn;

use common\models\Supplier;
use common\models\Payer;

//$this->title = 'Список позиций в счете';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = $modelPayment->invoice;
$this->params['breadcrumbs'][] = ['label' => 'Оплачиваемые счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="paymentinvoice-viewitem">
    <div class="col-md-6">
    <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title pull-left"><?= Html::encode('Счет № '. $modelPayment->invoice . ' от '. $modelPayment->date_invoice);?></h2>
                 <div class="clearfix"></div>
            </div>
    
     <div class="panel-body">
     <?= DetailView::widget([
            'model' => $modelPayment,
            'attributes' => [
           // 'idpaymenti',
                'invoice',
                'date_invoice',
                [
                    'attribute' => 'idpayer',
                    'value' => yii\helpers\ArrayHelper::getValue($modelPayment, 'payer.name'),
                ],
                'date_payment',
                'created_at',
           // 'updated_at',
            ],
        ]) ?>
     </div>
  </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="accounts-viewitem">
    <p>
        <?= Html::a('Добавить позицию в счет', ['additems', 'idinv' => $modelPayment->idpaymenti], 
                ['class' => 'btn btn-success', 
                 'visible' => yii::$app->user->can('admin') or yii::$app->user->can('Purchasegroup'),]) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProviderAccounts,
      //  'filterModel' => $searchModel,
        'showFooter'=>TRUE,
        'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline; '],
      //  'columns' =>$grid_columns,  
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'idord',
            'idelem',
            [
                'attribute' => 'idelem',
                'label' => 'Производитель',
                'value' => function($model){
                    return $model->elements->manufacturerName;
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
             //   'value' => 'elements.name',
                 'value' => function ($model, $key, $index) { 
                    return Html::a($model->elements->name, ['elements/vieworder', 'id' => $model->idelem]);
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
                  
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
            [
                'attribute' => 'idprice',
                'value' => function($data){
                    return $data->prices->price;
                }
              
            ],
            [
                'label' => 'Сумма без НДС',
                'attribute' =>'amount',
                'footer'=>TotalColumn::pageTotal($dataProviderAccounts->models,'amount'),
            ],
            'delivery',
           
          
             [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($model){
                    if($model->status == '2'){ //not active
                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Закано</span>';
                    }elseif($model->status == '3'){//active
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> На складе</span>';
                    }
                },
                'filter' => ['2'=> 'Заказано', '3' => 'На складе']
             
            ],
          
            'date_receive',

           
          //  ['class' => 'yii\grid\ActionColumn'],
     
        ],
    ]); ?>
</div>