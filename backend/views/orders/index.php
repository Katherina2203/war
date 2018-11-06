<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idorder',
            'name',
            'req_quantity',
            'idproduce',
            'idsupplier',
            // 'req_date',
            // 'executor',
            // 'aggr_date',
            // 'qty',
            // 'amount',
            // 'suppl_date',
            // 'date_payment',
            // 'contract',
            // 'date_onstock',
            // 'date_recept',
            // 'created_at',
            // 'updated_at',
            // 'idtheme',
            // 'iduser',
            // 'idstatus',
            // 'additional',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
