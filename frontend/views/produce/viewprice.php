<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PricesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Просмотр цены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

           // 'idpr',
           // 'idel',
            [
                        'attribute' =>  'unitPrice',
                        'format' => 'raw',
                        'value' => function($data){
                                 return $data->unitPrice. '/'. $data->forUP;
                        },
            ],
            'pdv',
            'usd',
            'created_at',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
