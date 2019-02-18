<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Category;
//use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// use common\models\Category;
//use backend\models\PricesSearch;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = 'Номенклатура Товаров';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="elements-index">
    <p>
        <?php echo Html::a('Создать новый товар', ['create'], ['class' => 'btn btn-success']) ?>
      
       
    </p>
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
   
<?php Pjax::begin(['id' => 'elements']); ?>  
    <?= GridView::widget([
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
         /*   [
                'attribute' => 'required',
                'label' => 'В заявках',
                'value' =>'purchaseorder.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],*/
          /*  [
                'attribute' => 'Ordered',
                'label' => 'Заказано',
                'value' =>'accounts.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],*/
            [
                'attribute' => 'quantity',
                'label' => 'На складе',
                'format' => 'raw',
                'value' => function($data){
                 //   return '<center><strong>'.$data->quantity.'</strong></center>'. '<br/>'. '<p>'. $data->updated_at.'</p>';
                    return '<center><strong>'.$data->quantity.'</strong></center>';
                },
                'contentOptions'=>['style'=>'width: 50px;'],
            ],
            [
                'attribute' => 'idproduce',
                'value' => function ($model) {
                    return empty($model->idproduce) ? '-' : $model->produce->manufacture;
                },
                'format' => 'text',
                'filter' => common\models\Produce::getProduceList()
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
                'contentOptions'=>['style'=>'width: 100px;'],
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width:45px;'],
            'template' => ' {prices} {viewfrom}',
           
            
            'buttons' => [
                'prices' => function ($url,$model,$key) {
                  $url = Url::to(['viewprice', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                            ['title' => 'Посмотреть цену']
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
                     $url ='prices/view?idelement='.$model->idel;
                return $url;}
                
              
                 },
            ], ],
        ],
    ]); ?>
    <?php Pjax::end([]); ?>   
</div>


