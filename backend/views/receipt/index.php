<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Прием товара';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новое получение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idreceipt',
            [
                'attribute' => 'request',
                'label' => '#Заявки',
                'format' => 'raw',
                'value' => function($data){
                        return Html::a($data->requests->idrequest, ['requests/view', 'id' => $data->requests->idrequest]);
                },
            ],
            'id',
            [
                'attribute' => 'id',
                'label' => 'Наименование',
                'value' => 'elements.name',
            ],
            
            [
                'attribute' => 'id',
                'label' => 'Номинал',
                'value' => 'elements.nominal',
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>'.$data->quantity.'</center></strong>';
                }
            ],
       /*     [
                'attribute' => 'idinvoice',
                'format' => 'raw',
                'value' => function($model){
                  //  return Html::a($model->paymentinvoice->invoiceitem, ['paymentinvoice/view', 'id' => $model->paymentinvoice->idpaymenti]);
         //   return    $model->paymentinvoice->idpaymenti;
                }, 
                //    return Html::a($data->paymentinvoice->invoiceitem, ['paymentinvoice/view', 'id' => $data->idinvoice]);
               // $data->paymentinvoice->invoice. ' '. $data->paymentinvoice->date_invoice;
               // }
            ],*/
            'date_receive',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
