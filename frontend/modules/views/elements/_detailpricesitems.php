<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
//use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PricesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//use backend\models\PricesSearch;
//$searchModel2 = new PricesSearch();
//$dataProvider2 = $searchModel2 -> search(Yii::$app->request->queryParams);
$this->title = 'Цены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-index">

    
    <?= GridView::widget([
        'dataProvider' => $dataProviderprice,
        'filterModel' => $searchModelprice,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idpr',
        //    'idel',
            
           
          //  'unitPrice',
            [
                'attribute' =>  'unitPrice',
                'value' => function($data){
                    return $data->unitPrice. '/'. $data->forUP;
                },
                'format' => 'raw',
            ],
          //  'forUP',
            'pdv',
            'usd',
            'created_at',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
