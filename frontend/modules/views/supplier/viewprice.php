<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PricesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Цены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-index">

    <h1><?= Html::encode($this->title) ?></h1>
 

    <p>
        <?= Html::a('Добавить цену', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idpr',
            'idel',
            [
                'attribute' =>  'idel',
                'label' => 'Название',
                'value' => 'elements.name',
            ],
              [
                'attribute' =>  'idel',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
            [
                'attribute' => 'idsup',
                'value' => 'supplier.name',
                'filter' => Html::activeDropDownList($searchModel, 'idsup', ArrayHelper::map(common\models\Supplier::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите поставщика']),
            ],
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

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
