<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

use common\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Номенклатура';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
   ['class' => 'kartik\grid\SerialColumn'],
    'idelements', 
    'box',
    [
      'attribute' => 'name',
      'label' => 'ValueManufacturerPartNumber', 
    ],
    [
      'attribute' => 'nominal',
      'label' => 'ValueDescription', 
    ],
    'quantity',
    [
        'attribute' => 'idproduce',
        'label'  => 'ValueManufacturer ',
        'value' => 'produce.manufacture',
    ],
    [
        'attribute' => 'active',
        'value' => function($data){
                    if($data->active == 1){
                        return 'Актуально';
                    }elseif($data->active == 2){
                        return 'Устарело';
                    }
                   
                },
    ],
    
];

?>
<div class="elements-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'elements']); ?>  
    <?php  echo
 /*   ExportMenu::widget([
    'dataProvider' => $dataProvider,
   'columns' => $gridColumns,
    'fontAwesome' => true,
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-default'
        ]
    ]) . "<hr>\n".
  * */
  
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
       // 'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'resizableColumns'=>true,
      //  'fontAwesome' => true,

        // 'floatHeader' => true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
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
                'attribute' =>  'box',
                'contentOptions'=>['style'=>'width: 80px;'],
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
                'format' => 'raw',
                'value' => function($data){
                    return '<strong>'.$data->quantity.'</strong>';
                },
                'contentOptions'=>['style'=>'width: 50px;'],
            ],
            [
                'attribute' => 'idproduce',
             /*   'value' => function ($model) {
                  //  return empty($model->idproduce) ? '-' : $model->produce->manufacture;
                     return $model->produce->manufacture;
                },*/
                'value' => 'produce.manufacture',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->indexBy('idpr')->all(), 'idpr', 'manufacture'),['class'=>'form-control','prompt' => 'Выберите производител']),
            ],
            [
                'attribute' => 'idcategory',
               /* 'value' => function ($model) {
                    return empty($model->idcategory) ? '-' : $model->category->name;
                },*/
                'value' => 'category.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idcategory', Category::getHierarchy(), (['class'=>'form-control','prompt' => 'Выберите категорию'])),
              
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
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
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
            ],
            [
            'class' => 'yii\grid\ActionColumn',
       
            'contentOptions' => ['style' => 'width:45px;'],
            'template' => '{update} {delete} {prices} {accounts} {viewfrom}',
           
            
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
<?php Pjax::end(); ?>  
</div>
