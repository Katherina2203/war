
<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use backend\components\TotalColumn;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список позиций в счете';
$this->params['breadcrumbs'][] = ['label' => 'Текущие счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h2><?php // Html::encode($this->title) ?>
    Счет № <?= $modelpay->invoice . ' От ' . $modelpay->date_invoice ?>
    </h2>
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <?php Pjax::begin(); ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idinvoice], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idinvoice], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

     <?= DetailView::widget([
        'model' => $modelpay,
        'attributes' => [
            'idpaymenti',
            [
                'attribute' => 'idsupplier',
                'value' => ArrayHelper::getValue($modelpay, 'supplier.name'),
            ],
            [
                'attribute' => 'invoice',
                'format' => 'raw',
                'value' => '№ ' . '<strong>' . $modelpay->invoice . '</strong>'. ' от ' . $modelpay->date_invoice, 
            ],
            [
                'attribute' =>'idpayer', 
                'value' => ArrayHelper::getValue($modelpay, 'payer.name'),
            ],
           
            'date_payment',
            [
                'attribute' => 'confirm',
                'format'=>'raw',
                'value'=>
                
                $modelpay->confirm ==0 ? '<span class="label label-danger">Не подствержден</span>' : '<span class="label label-success">Подтвержден</span>',
                'widgetOptions' => [
                     'pluginOptions'=>[
                            '0'=>'Не подствержден',
                            '1'=>'Подтвержден',
                            '2'=>'Отмена',
                        ]
                ],
            ],
            
        //    'created_at',
           // 'updated_at',
        ],
    ]) ?>
    
    <p>
        <?= Html::a('Добавить товар в счет', ['accounts/createitem', 'idinvoice' => $modelpay->idpaymenti], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="tips">Сумма счета указана без НДС!</div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'showPageSummary' => true,
      //  'footerRowOptions' => ['style'=>'font-weight:bold;text-decoration: underline; '],
      //  'columns' =>$grid_columns,  
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
        'floatHeader' => true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'idord',
            'idelem',
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
                },
                'pageSummary'=>'Итого без ПДВ',
                'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            ],
            [
                'attribute' => 'idprice',
                'value' => function($data){
                    return $data->prices->price;
                },
                
            ],
            [
             //   'class'=>'kartik\grid\FormulaColumn',
                'label' => 'sum',
                'attribute' =>'amount',
              //  'footer'=>TotalColumn::pageTotal($dataProvider->models,'amount'),  //будет необходимо, когда добавляешь несколько строк с пдв и без
                'pageSummary'=>true,
              //  'pageSummaryFunc'=> GridView::F_AVG
            ],
          /*  [
                    'class'=>'kartik\grid\FormulaColumn',
                  //  'attribute' =>'amount',
                        'header'=>'Сумма без НДС',
                        'value'=>function ($model, $key, $index, $widget) { 
                            $p = compact('model', 'key', 'index');
                            return $widget->col(4, $p) * $widget->col(5, $p);
                        },
                        'mergeHeader'=>true,
                        'width'=>'150px',
                        'hAlign'=>'right',
                        'format'=>['decimal', 2],
                        'pageSummary'=>true,
                               
                'pageSummaryFunc'=> GridView::F_AVG
                                
                ],*/
         //   ],
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

           ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
  <?php Pjax::end(); ?>
</div>
