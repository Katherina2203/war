<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
//use kartik\export\ExportMenu;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$gridColumns = [ // для эспорта убрать комменты
  //  ['class' => 'kartik\grid\SerialColumn'],
  //  'idelements', 
  //  'box',
  //  'name',
   // 'nominal',
   // 'quantity',
  /*  [
        'attribute' => 'idproduce',
        'value' => 'produce.manufacture',
    ],
    [
        'attribute' => 'idcategory',
        'value' => 'category.name',
         'format' => 'text',
                 'filter' => Html::activeDropDownList($searchModel, 'idcategory', ArrayHelper::map(\common\models\Category::find()->select(['name_ru', 'idcategory'])->indexBy('idcategory')->all(), 'idcategory', 'name_ru'),['class'=>'form-control','prompt' => 'Выберите категорию']),
    ],*/
    
    
    ];

/*echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns
]);

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns
]);
*/
$this->title = $model->idcategory . 'category.name';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-index">

    <h1><?= Html::encode($this->title). $model->category ?></h1>
    <?php  echo $this->render('_searchitems', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
     //   'model' => $model,
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'resizableColumns'=>true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
        /*    [
                'class' => 'yii\grid\ActionColumn',
               // 'contentOptions' => ['style' => 'width:45px;'],
                  'buttons' => [
                'prices' => function ($url,$model,$key) {
                  $url = Url::to(['viewprice', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                            ['title' => 'Посмотреть цену']
                            );
                },
            ],*/
         //   ['class' => 'yii\grid\SerialColumn'],

            
            [
                'attribute' => 'image',
                'label' => 'Image',
               'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'value' => function ($model) {
                  //  if($data->image){
                         return Html::img(Yii::getAlias('@web').'/images/' . $model->image,//$data['image'],
                               
                         ['width' => '60px']);
                //    }else{
                //        return '<span>no image</span>';
                 //   }
                  // return $model->displayImage;
                },
            ],
            [
                'attribute' => 'idelements', 
                //'filter' => false,
            ],
            
            [
                'attribute' => 'box',
                'label' => 'Расположение',
            ],
            [
               'attribute'=>'name',
               'format'=>'raw',
               'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idelements]);
                },
            ],
                        
            'nominal',
            [
                'attribute' => 'quantity',
                'label' => 'На складе',
                
              
               // 'elements.qty',
              //  'format' => 'text',
                
            ],
        /*    [
                'attribute' => 'Ordered',
                'label' => 'Заказано',
                'value' => 'accounts.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],*/
       /*     [
                'attribute' => 'Reserve',
                'label' => 'Резерв',
                'value' =>'reserve.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],*/
            [
                'attribute' => 'idproduce',
             /*   'value' => function ($model) {
                  //  return empty($model->idproduce) ? '-' : $model->produce->manufacture;
                     return $model->produce->manufacture;
                },*/
                
                'value' => 'produce.manufacture',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->indexBy('idpr')->all(), 'idpr', 'manufacture'),['class'=>'form-control','prompt' => 'Выберите производител']),
            ],
            [
                'attribute' => 'idcategory',
               /* 'value' => function ($model) {
                    return empty($model->idcategory) ? '-' : $model->category->name;
                },*/
                'value' => 'category.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idcategory', Category::getHierarchy(), (['class'=>'form-control','prompt' => 'Выберите категорию']))
               // 'filter' => Html::activeDropDownList($searchModel, 'idcategory', ArrayHelper::map(\common\models\Category::find()->select(['name_ru', 'idcategory'])->indexBy('idcategory')->all(), 'idcategory', 'name_ru'),['class'=>'form-control','prompt' => 'Выберите категорию']),
            ],
            /*[
                'attribute' => 'created_at',
               // 'format' => ['date', 'php:Y-m-d']
            ],*/
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
       
            'contentOptions' => ['style' => 'width:45px;'],
            'template' => '{view} {update} {delete} {prices} {accounts} {viewfrom}',
           
            
            'buttons' => [
                'prices' => function ($url,$model,$key) {
                  $url = Url::to(['viewprice', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                            ['title' => 'Посмотреть цену']
                            );
                },
                'accounts' => function ($url,$model,$key) {
                  $url = Url::to(['tostock', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,
                            ['title' => 'Положить на склад']
                            );
                },
                'viewfrom' => function ($url,$model,$key) {
                  $url = Url::to(['viewfrom', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-minus"></span>', $url,
                            ['title' => 'Посмотреть что взято со склада']
                            );
                },
            'urlCreator' => function ($action, $model, $key, $index) {
                 if ($action === 'receipt') {
                     $url = yii::$app->controller->createUrl('receipt'); 
                 return $url;}
                 
                if ($action === 'prices'){
                     $url ='elements/viewprice?idel='.$model->idel;
                return $url;}
                
                if ($action === 'fromstock'){
                     $url ='fromstock/create?idelements='.$model->idelements;
                     return $url;
                }
                 },
            ],
        ],
        ],
    ]); ?>
</div>
