<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Elements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Elements', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idelements',
            'box',
            'name',
            'nominal',
            [
                'attribute' => 'quantity',
                'label' => 'Onstock',
                'value' => 'quantity',
                'format' => 'text',
                
            ],
             [
                'attribute' => 'Ordered',
                'label' => 'Ordered',
                'value' =>'order.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],
            [
                'attribute' => 'idproduce',
                'value' => 'produce.manufacture',
                'format' => 'text',
              //  'filter' => \app\models\Produce::getProduceList()
            ],
            [
                'attribute' => 'idcategory',
                'value' => 'category.name',
                'format' => 'text',
              //  'filter' => \app\models\Category::getCategoriesList()
            ],
                [
            'label' => 'Image',
            'format' => 'raw',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            'value' => function($data){
                return Html::img(Url::toRoute($data->image),[
                    'alt'=>'No image',
                    'style' => 'width:40px;float:center; '
                ]);
            },
            ],
             [
                'attribute' => 'date_added',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'active',
                'filter'=>array("1"=>"Active","2"=>"Out of production"),
            ],

         
  
        ],
    ]); ?>
</div>


