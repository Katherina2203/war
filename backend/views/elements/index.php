<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use common\models\Category;
use common\models\Elements;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = yii::t('app', 'Elements');
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
    <p>
        <?php echo Html::a(yii::t('app', 'Create new element'), ['create'], ['class' => 'btn btn-success']) ?>
      
       
    </p>
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span><?= yii::t('app', 'Search by')?>:</span>
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
            [
                'attribute' => 'quantity',
                'label' => 'Onstock',
                'format' => 'raw',
                'value' => function($data, $index){
                    
                    if ($data->quantity == '0'){
                        return '<center><strong>' . $data->quantity.'</strong></center>'. '<br/><center><small>Will be: '. $index . '</small></center>';
                    }else{
                        return '<center><strong>' . $data->quantity.'</strong></center>';
                    }  
                },
                'contentOptions'=>['style'=>'width: 50px;'],
            ],
            [
                'attribute' => 'idproduce',
             /*   'value' => function ($model) {
                  //  return empty($model->idproduce) ? '-' : $model->produce->manufacture;
                     return $model->produce->manufacture;
                },*/
               // 'value' => 'produce.manufacture',
                'value' => function($data){
                    return  empty($data->idproduce) ? '-' : HTML::a($data->produce->manufacture, ['produce/viewitem', 'id' => $data->idproduce]);
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->indexBy('idpr')->all(), 'idpr', 'manufacture'),
                        ['class'=>'form-control','prompt' => yii::t('app', 'Choose manufacturer')]),
            ],
            [
                'attribute' => 'idcategory',
               /* 'value' => function ($model) {
                    return empty($model->idcategory) ? '-' : $model->category->name;
                },*/
                'value' => 'category.name',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'idcategory', Category::getHierarchy(), (['class'=>'form-control','prompt' => yii::t('app', 'Choose category')])),
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function($data){
                    if($data->active == '1'){
                        return '<span class="label label-success">Актуально</span>';
                    }elseif($data->active == '2'){
                        return '<span class="label label-danger">Устарело</span>';
                    }
                   
                },
                'filter'=>['1' => 'Актуально', '2' => 'Снято с производства'],
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width:45px;'],
            'template' => '{update} {delete} {prices} {accounts} {viewfrom} {createfromquick}',
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
                'createfromquick' => function ($url,$model,$key) {
                  $url = Url::to(['createfromquick', 'idel' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                            ['title' => 'взять со склада быстро']
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
                
                if ($action === 'createfromquick'){
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
