<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use common\models\Price;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поставщики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать поставщика', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idsupplier',
           
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(Html::encode($data->name), Url::to(['viewprice', 'id' => $data->idsupplier]));
                }
            ],
            'address',
            'manager',
            'phone',
            'website',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
