<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = $model->idpaymenti;
$this->params['breadcrumbs'][] = ['label' => 'Текущие счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idpaymenti], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idpaymenti], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idpaymenti',
            [
                'attribute' => 'idsupplier',
                'value' => ArrayHelper::getValue($model, 'supplier.name'),
            ],
            [
                'attribute' => 'invoice',
                'format' => 'raw',
                'value' => '№ ' . '<strong>' . $model->invoice . '</strong>'. ' от ' . $model->date_invoice, 
            ],
            [
                'attribute' =>'idpayer', 
                'value' => ArrayHelper::getValue($model, 'payer.name'),
            ],
           
            'date_payment',
            [
                'attribute' => 'confirm',
                'format'=>'raw',
                'value' => function($model){
                           if($model->confirm == '0'){ //not active
                               return '<span class="label label-warning" style="color: #d05d09"> Не рассмотрено</span>';
                           }elseif($model->confirm == '1'){//active
                               return '<span class="label label-success" style="color: green"> Подтверждено</span>';
                           }elseif($model->confirm == '2'){//active
                               return '<span class="label label-danger" style="color: #888"> Отмена</span>';
                           }
                },
            ],
            
        //    'created_at',
           // 'updated_at',
        ],
    ]) ?>

</div>

    <p>
        <?= Html::a('Добавить товар в счет', ['accounts/createitem', 'idinvoice' => $model->idpaymenti], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
         <div class="box-header with-border"><h3 class="box-title">Позиции в счете</h3></div>
        <div class="box-body">
     <?= GridView::widget([
        'dataProvider' => $dataProvideracc,
        'filterModel' => $searchModelacc,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idord',
            'idelem',
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
               // 'value' => 'elements.name',
                'value' => function($modelacc, $key, $index){
                    return Html::a($modelacc->elements->name, ['elements/view', 'id' => $modelacc->idelem]);
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Производитель',
                'value' => function($data){
                    return $data->elements->manufacturerName;
                },
              //  'filter' => Html::activeDropDownList($searchModelacc, 'idelem', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->indexBy('idpr')->all(), 'idpr', 'manufacture'),['class'=>'form-control','prompt' => 'Выберите производител']),
            ],
            [
                'attribute' => 'idprice',
                'format' => 'raw',
                'value' => function($modelacc, $key, $index){
                    return Html::a(($modelacc->prices->unitPrice. '/' . $modelacc->prices->forUP), ['prices/view', 'id' => $modelacc->prices->idel]);
                }
            ],
            [
                'attribute' =>  'quantity',
                'format' => 'raw',
                'value'=> function($data){
                    return '<strong><center>' . $data->quantity . '</strong></center>';
                }
            ],
           
          //  'idinvoice',
           
          //  'account_date',
            [
                'attribute' => 'amount',
                'format' => 'raw',
                'value' => function($data){
                    return $data->amount; // . ' '. $data->prices->idcurrency . 'currency.currency';
                }
            ],
            
         //   [
         //       'attribute' => 'idinvoice',
               // 'format' => 'raw',
              /*  'value' => function($model, $key, $index){
                    return Html::a($model->paymentinvoice->invoice, ['paymentinvoice/view', 'id' => $model->paymentinvoice->idpaymenti]);
                }*/
         //   ],
            'delivery',
           
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($modelacc){
                    if($modelacc->status == '2'){ //not active
                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Закано</span>';
                    }elseif($modelacc->status == '3'){//active
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> На складе</span>';
                    }elseif($modelacc->status == '4'){//active
                       return '<span class="glyphicon glyphicon-remove" style="color: #888"> Отмена</span>';
                    }
                },
                'filter' => ['2'=> 'Заказано', '3' => 'На складе', '4' => 'Отмена']
             
            ],
            'date_receive',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete} {receipt}',
             'buttons' => [
                 'receipt' => function ($url,$modelacc,$key) {
                      $url = Url::to(['receipt', 'idord' => $key, 'idel' => $modelacc->idelem]);
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара']);
                },
             ],
            ],
        ],
    ]); ?>
    </div>
  </div>

