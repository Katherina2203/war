<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\TotalColumn;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Товар в счете';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-detailinvoiceitems-index">

    <h3><?= Html::encode($this->title)  ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvideracc,
        'filterModel' => $searchModelacc,
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

          //  'idord',
          //  'idelem',
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->elements->name, ['elements/view', 'id' => $model->idelem]);
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
            [
                'attribute' => 'idprice',
                'value' => function($data){
                    return $data->prices->price;
                }
              
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
            [
                'label' => 'Сумма без НДС',
                'attribute' =>'amount',
                'footer'=>TotalColumn::pageTotal($dataProvideracc->models,'amount'),
            ],
            'delivery',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($model){
                    if($model->status == '2'){ //not active
                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Заказано</span>';
                    }elseif($model->status == '3'){//active
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> На складе</span>';
                    }
                },
               // 'filter' => ['2'=> 'Заказано', '3' => 'На складе']
            ],
            'date_receive',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete} {receipt}',
             'buttons' => [
                 'receipt' => function ($url,$model,$key) {
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара']);
                },
             ],
            ],
        ],
    ]); ?>
</div>
