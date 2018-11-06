<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
];

$this->title = 'Журнал заказов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderorder,
        'filterModel' => $searchModelorder,
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
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->idrequest == '1'){
                return ['style' => 'color:#ba1313'];
            }else{
                 return ['class' => 'default'];
            }
           
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         
            'idrequest',
            'idelement',
            [
                'attribute' => 'idelement',
                'label' => 'Наименование', 
                'value' => 'elements.name',
            ],
            [
                'attribute' => 'idelement',
                'label' => 'Номинал', 
                'value' => 'elements.nominal',
            ],
            'quantity',
            'date',
        //    'delivery',
          //  'idprice',
           
          
          /*  [
                'attribute' => 'idinvoice',
                'label' => 'Дата счета',
                'value' => 'accounts.account_date'
            ],*/
            
             'idpo',
            
           
 
            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {viewprice}', 
             'buttons' => [
                   'viewprice' => function ($url,$model) {
                  $url = Url::to(['viewprice', 'idelement' => $model->idelement]);
                    return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                            ['title' => 'Посмотреть цены']
                            );
                },
              ],
            ],
        ],
    ]); ?>
</div>
