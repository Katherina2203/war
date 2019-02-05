<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];
$this->title = 'Прием товара';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="color: green">
       Поиск на этой странице на данный момент не работает
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'resizableColumns'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'idreceipt',
        //    'id',
            [
                'attribute' => 'id',
                'label' => 'Наименование',
                'value' => 'elements.name',
            ],
            [
                'attribute' => 'id',
                'label' => 'Поступление',
                'value' => 'elements.nominal',
            ],
            'quantity',
            
            [
                'attribute' => 'idinvoice',
                'value' => 'accounts.idord'
            ],
            'date_receive',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
