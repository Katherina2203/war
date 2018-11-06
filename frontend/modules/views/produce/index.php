<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProduceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Производители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produce-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Produce', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
          //  'idpr',
            [
                'attribute' =>'manufacture',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(Html::encode($data->manufacture), Url::to(['viewitem', 'id' => $data->idpr]));
                }
            ],
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
