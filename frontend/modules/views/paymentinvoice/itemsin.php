
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\TotalColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список позиций в счете';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">
    
    <h2>Счет № <?= $modelpay->invoice . ' <small>от ' . $modelpay->date_invoice. '</small>' ?></h2>
    <div class="pad margin no-print">
        <div class="callout callout-info">
            <h4><i class="fa fa-info"></i> Обратите внимание!</h4>
           При наведении на единицу товара можно посмотреть заказчика и тему
        </div>
    </div>
    
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header"><span><?= Html::img(Yii::getAlias('@web').'/images/suppliers/' . $modelpay->supplier->logo, ['width' => '120px'])?></span>
                    <?= $modelpay->supplier->name;?>
                <small class="pull-right">Date:</small>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
             <div class="row">
                <center><strong><?= 'Счет №'. $modelpay->invoice. ' от '.  $modelpay->date_invoice?></strong></center>
            </div>
            <div class="col-sm-4 invoice-col">
                <?= '<b>Поставщик:</b> <br/>' . $modelpay->supplier->name;//idpayer  ?><br/>
                <?= $modelpay->supplier->address;  ?><br/>
                <?= $modelpay->supplier->phone;  ?><br/>
            </div>
            <div class="col-sm-4 invoice-col">
                 <?= '<b>Плательщик:</b> <br/>' . $modelpay->payer->name;//idpayer  ?><br/>
                Вул. Печенизька, 8, Киев, 04107<br/>
            </div>
            <div class="col-sm-4 invoice-col">
                 <?=  '<b>' .yii::t('app', 'Approving') . ': </b>' ?>
                <p>  
                    <?php    
                        if($modelpay->confirm == '0'){
                            echo '<span>Не рассмотрено руководством</span>';
                        }elseif($modelpay->confirm == '1'){
                            echo '<span>Утверждено руководством</span>';
                        }elseif($modelpay->confirm == '2'){
                            echo '<span>Отменено руководством</span>';
                        }
                    ?>
                    <?= Html::a('Approve invoice', ['accounts/createitem', 'idinvoice' => $modelpay->idpaymenti], ['class' => 'btn btn-default']) ?>
                </p>
              
                    
                <p> <?= '<b>' . yii::t('app', 'Date payment') . ': </b>'?>
                    <?php 
                        if($modelpay->date_payment == ''){
                            echo Html::a('Appoint date payment', ['createitem', 'date_payment' => $modelpay->date_payment], ['class' => 'btn btn-default']);
                        }else{
                                echo  '<b>'.$modelpay->date_payment.'</b>';
                               }
                            ?>
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'footerRowOptions' => ['style'=>'font-weight:bold;text-decoration: underline; '],
      //  'columns' =>$grid_columns,  
        //'showPageSummary'=>$pageSummary,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'idelem',
                'label' => 'Производитель',
                'format' => 'raw',
                'value' => function($model){
                    return '<center>' . $model->produce->manufacture . '</center>';
                }
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
             //   'value' => 'elements.name',
                'value' => function ($model, $key, $index) { 
                   // return Html::a($model->elements->name, ['elements/vieworder', 'id' => $model->idelem]);
                  return Html::tag('span', 
                                    Html::a($model->elements->name, ['elements/vieworder', 'id' => $model->idelem]), 
                                    [
                                        'title'=> yii::t('app', 'Заказчик'). ': '.$model->requests->getCustomer().', '. yii::t('app', 'Проект'). ': '. $model->requests->getProject(),
                                        'data-toggle'=>'tooltip',
                                        'style'=>' cursor:pointer;'//text-decoration: underline;
                                    ]);
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
                'attribute' => 'amount',
                'footer' => TotalColumn::pageTotal($dataProvider->models,'amount'),
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

           
           // ['class' => 'yii\grid\ActionColumn'],
     
        ],
    ]); ?>
            </div>
            
            <div class="row">
                <div class="col-xs-6">
                    <p><b>Информация о поставщике: </b></p>
                    Менеджер: <?= $modelpay->supplier->manager;  ?><br/>
                    <?= $modelpay->supplier->phone;  ?><br/>
                   <?= $modelpay->supplier->website;  ?><br/>
                </div>
            
                <div class="col-xs-6">
                     <p>Сумма с НДС: 
                  <strong><?= 1.2*TotalColumn::pageTotal($dataProvider->models,'amount')?><strong>
                    
                    </p>
                </div>
            </div>
            
            <div class="row no-print">
                
            </div>
        </div>
    </section>
  
    
    
    


   
    
    
</div>
