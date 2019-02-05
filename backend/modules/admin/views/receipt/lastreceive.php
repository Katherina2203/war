<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Последнее поступление товара';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать новое получение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'resizableColumns'=>true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

        //    'idreceipt',
        //    'id',
          /*  [
                'attribute' => 'id',
                'value' => 'elements.image',
            ],*/
            [
                'attribute' => 'id',
                'label' => 'Наименование',
                'format' => 'raw',
                'value' => function($name){
                    return $name->elements->name;
                },
            ],
            
            [
                'attribute' => 'id',
                'label' => 'Номинал',
                'format' => 'html',
                 'value' => function($name){
                    return $name->elements->nominal;
                },
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong>'.$data->quantity.'</strong>';
                }
            ],
            [
                'attribute' => 'idinvoice',
                'label' => 'Счет',
                'format' => 'html',
               // 'value' => 'accounts.idinvoice'
                'value' => function($invoice){
                   return ArrayHelper::getValue($invoice, 'accounts.idinvoice');
                }
               /* 'value' => function($model){
                    $invoice = '';
                    foreach ($model->accounts as $key->$invoic){
                        $invoice .= Html::a($invoic['invoice'], ['/paymentinvoice/view', 'id' => $model['id']]);
                    }
                    return $invoice;
                }*/
            ],
            'date_receive',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
