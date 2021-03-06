<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = 'Текущие заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
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
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

         //   'idpo',
            'idrequest',
           [
            'attribute' => 'idelement',
            'format' => 'html',
            'label' => 'Image',
            'value' => function ($data) {
                return Html::img('@web/images/' . $data['idelement'],
                    ['width' => '60px']);
            },
            ],
            [
                'attribute' => 'idelement',
                'label' => 'Наименование', 
                'value' => 'elements.name',
                /*'value' => function ($model, $key, $index) { 
                    return Html::a($model->idelement, ['view', 'idelement' => $model->idelement]);
                },*/
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
           
             [
                'attribute' => 'idinvoice',
                'label' => 'Счет',
                'value' => 'accounts.account'
              /*  'value' => function(\common\models\Purchaseorder $account){
                    return $account->idelement->account. 'от '. $account->account_date;
                }*/
            ],
            [
                'attribute' => 'idinvoice',
                'label' => 'Дата счета',
                'value' => 'accounts.account_date'
             /*   'value' => function(\common\models\Purchaseorder $account){
                    return $account->account. 'от '. $account->account_date;
                }*/
            ],
            
            [
                'attribute' => 'idinvoice',
                'label' => 'Ожидаемая дата',
                'value' => 'accounts.date_receive'
            ],
            
           
 
         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
