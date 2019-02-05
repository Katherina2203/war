<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товар в счете';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    
    
    <?= GridView::widget([
                'dataProvider' => $dataProvideracc,
                'filterModel' => $searchModelacc,
                 'columns' => [
                   //      ['class' => 'yii\grid\SerialColumn'],

                     'idord',
          
                    [
                        'attribute' => 'quantity',
                        'format' => 'raw',
                        'value' => function($data){
                            return '<center><strong>' . $data->quantity . '</strong></center>';
                        }
                    ],
                    
                    [
                       'attribute' => 'idprice',
                       'value' => 'prices.unitPrice',
                    ],
                    'amount',
                    [
                       'attribute' => 'idinvoice',
                       'format' => 'raw',
                        'value' => function($data){
                            if($data->idinvoice == null){
                                return '№ ' . $data->account . ' от ' . $data->account_date;
                            }else{
                                return Html::a($data->idinvoice, ['paymentinvoice/view', 'id' => $data->idinvoice]);
                            }
                        }
                       // 'value' => 'paymentinvoice.invoicedate',
                     /*  'value' => function($model, $key, $index){
                            return Html::a($model->paymentinvoice->invoicedate, ['paymentinvoice/view', 'id' => $model->idpaymenti]);
                        },*/
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
                    
               // 'filter' => ['2'=> 'Заказано', '3' => 'На складе']
            ],
          //  'status.status',
          
                    'date_receive',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete} {receipt}',
                        'controller' => 'accounts',
                        'buttons' => [
                            'receipt' => function ($url,$model,$key) {
                                $url = Url::to(['createreceipt', 'idord' => $key, 'idel' => $model->idelem]);
                                return $model->status == '2' ? Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара'])
                                : '';
                            },
                        ],
                    ],
          
                ],
            ]);
           ?>
</div>
