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
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новое получение', ['createreceipt'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderrec,
        'filterModel' => $searchModelrec,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idreceipt',
            'id',
            [
                'attribute' => 'id',
                'value' => 'elements.name',
            ],
            
            [
                'attribute' => 'id',
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
