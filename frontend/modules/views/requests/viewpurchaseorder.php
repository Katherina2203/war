<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал заказов';
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         //   'idpo',
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
           
            [
                'attribute' => 'idinvoice',
                'label' => 'Счет',
                'value' => 'accounts.account'
            ],
            [
                'attribute' => 'idinvoice',
                'label' => 'Дата счета',
                'value' => 'accounts.account_date'
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
