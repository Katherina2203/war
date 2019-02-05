<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
           // 'idelements',
            [
                'label' => 'Image',
                 //  'format' => 'raw',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
          /*  'value' => function($data){
                return Html::img(Url::toRoute($data->image),[
                    'alt'=>'No image',
                    'style' => 'width:40px;float:center; '
                ]);
            },*/
      
            ],
            
            [
                'attribute' => 'box',
                'label' => 'Расположение',
            ],
            'name',
            'nominal',
            [
                'attribute' => 'quantity',
                'label' => 'На складе',
                'value' => 'quantity',
                'format' => 'text',
                
            ],
            [
                'attribute' => 'Ordered',
                'label' => 'Заказано',
                'value' =>
                /*function($data){
                     return $data->requests->quantity;
                },*/
                'requests.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],
            
            [
                'attribute' => 'Reserve',
                'label' => 'Резерв',
                'value' =>'reserve.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],
            
         
            [
                'attribute' => 'idcategory',
                'value' => 'category.name',
                'format' => 'text',
              //  'filter' => \app\models\Category::getCategoriesList()
            ],
      
          
         
             [
                'attribute' => 'created_at',
               // 'format' => ['date', 'php:Y-m-d']
            ],
             [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function($data){
                    if($data->active == 1){
                        return '<span class="label label-success">Актуально</span>';
                    }elseif($data->active == 2){
                        return '<span class="label label-danger">Устарело</span>';
                    }
                   
                },
                'filter'=>['1' => 'Актуально', '2' => 'Снято с производства'],
            ],

           [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'elements',
            'contentOptions' => ['style' => 'width:45px;'],
            'template' => '{view} {update} {delete} {prices} {accounts} {outofstock}',
           
            
            'buttons' => [
                'prices' => function ($url,$model,$key) {
                  $url = Url::to(['viewprice', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                            ['title' => 'Посмотреть цену']
                            );
                },
                'accounts' => function ($url,$model,$key) {
                    $url = Url::to(['addonstock', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,
                            ['title' => 'Add to accounts']);
                },
                'outofstock' => function ($url,$model,$key) {
                    $url = Url::to(['fromstock', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-minus"></span>', $url,
                            ['title' => 'Взять со склада']);
                },
             'urlCreator' => function ($action, $model, $key, $index) {
                 if ($action === 'accounts') {
                     $url = yii::$app->controller->createUrl('accounts'); // your own url generation logic
                 return $url;}
                 
                if ($action === 'prices'){
                     $url ='prices/view?idelement='.$model->idel;
                return $url;}
                
                if ($action === 'outofstock'){
                     $url ='outofstock/view?id='.$model->idelement;
                     return $url;
                }
                 },
            ],
        ],
        ],
    ]); ?>
</div>
