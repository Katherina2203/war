<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\detail\DetailView;
//use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Elements */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-view">

    <h1><?= Html::encode($this->title) ?></h1>

   
 <div class="row" style="padding: 0 15px;">
    <div class="col-sm-2" style="float:left;  border: 1px solid #ccc;">
        <?php // Html::img(Yii::$app->request->baseUrl.'/images/'.$model->image, ['max-width'=>'300px', 'max-heigth' => '300px'],['alt' => 'image']);?>
     <?= Html::img(Url::to('@web/images/0306.jpg'.$model->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
    </div>
     <div class="col-sm-5">
         <h3> Описание</h3>
    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'hover'=>true,
        'attributes' => [
            'idelements',
            'box',
            'name',
            'nominal',

            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$model->quantity.'</strong>', 
                'displayOnly'=>true,
               //  'inputContainer' => ['class'=>'col-sm-6'] 
            ],
            [
                'attribute' => 'idproduce',
                'value' => ArrayHelper::getValue($model, 'produce.manufacture')
            ],
            [
                'attribute' => 'idcategory',
                'value' => ArrayHelper::getValue($model, 'category.name_ru')
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'active',
                'label'=>'Актуальность',
                'format'=>'raw',
                'value'=>$model->active ==1 ? '<span class="label label-success">Актуально</span>' : '<span class="label label-danger">Устарело</span>',
              // 'type' => DetailView::ELEMENT_ACTIVE,
               'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Актуально',
                        'offText' => 'Устарело',
                    ]
                ],
            ],
        ],
    ]) ?>
         </div>
    
 <div class="col-md-3">
     <h3 style="padding: 10px;">Заявка № <?= Html::encode($modelrequests->idrequest)?></h3>
    <?= DetailView::widget([
        'model' => $modelrequests,
        'hover'=>true,
        'condensed'=>false,
        'attributes' => [
            'idrequest',
            'name',
            'description:ntext',
            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$modelrequests->quantity.'</strong>', 
                'displayOnly'=>true
                
            ],
            'required_date',
            [
                'attribute' => 'idproduce',
                'format' => 'raw',
                'value' => 'produce.manufacture',
            ],
            [
                'attribute' => 'iduser',
                'value' => ArrayHelper::getValue($modelrequests, 'users.surname')
            ],
            [
                'attribute' => 'idproject',
                'value' => ArrayHelper::getValue($modelrequests, 'themes.name')
            ],
            [
                'attribute' => 'idsupplier',
                'value' => ArrayHelper::getValue($modelrequests, 'supplier.name')
            ],

           // 'img',
            'created_at',
          //  'updated_at',
            'note',
            [   'class' => 'kartik\grid\DataColumn',
                'attribute' => 'status',
                'label'=>'Актуальность',
                'format'=>'raw',
                'value'=> $modelrequests->status == 0 ? '<span class="label label-success">Не обработано</span>' : '<span class="label label-danger">Актуально</span>',
                //$model->status ? 
                //     '<span class="label label-success">Актуально</span>' : '<span class="label label-danger">Закрыто</span>',
               // 'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions'=>[
                        'pluginOptions'=>[
                            '0'=>'Не обработано',
                            '1'=>'Актуально',
                            '2'=>'Отмена',
                            '3'=>'Выполнено',
                        ]
                ]
                
            ],
        ],
    ]) ?>
</div>
       
    
</div>
    <div class="row" style="padding-left: 15px;">
        <div class='col-sm-6'>
            <h3> Цена</h3>
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
              //  'filterModel' => $searchModel2,
                 'columns' => [
               // ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' =>  'unitPrice',
                        'format' => 'raw',
                        'value' => function($data){
                                 return $data->unitPrice. '/'. $data->forUP;
                        },
                    ],
                    'pdv',
                    'usd',
                    [
                         'attribute' => 'idsup',
                         'value' => 'supplier.name',
                     //    'filter' => Html::activeDropDownList($searchModel2, 'idsup', ArrayHelper::map(common\models\Supplier::find()->select(['idsupplier', 'name'])->indexBy('idsupplier')->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите поставщика']),
                    ],
                   
                   
                    'created_at',
                ], 
            ]);
           ?>
        </div>
      
        
        <div class="col-md-6">
             <h3>Поступление на склад</h3>
             <?= GridView::widget([
                'dataProvider' => $dataProvideracc,
                //'filterModel' => $searchModelacc,
                 'columns' => [
                   //      ['class' => 'yii\grid\SerialColumn'],

                 //    'idord',
          
                    'quantity',
                    [
                       'attribute' => 'idprice',
                       'value' => 'prices.unitPrice',
                    ],
                    'amount',
                    [
                       'attribute' => 'idinvoice',
                       'value' => 'paymentinvoice.invoice',
                    ],
           
                    'delivery',
                    [
                       'attribute' => 'status',
                       'format' => 'html',
                       'value' => function($model){
                           if($model->status == '2'){ //not active
                               return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Закано</span>';
                           }elseif($model->status == '3'){//active
                               return '<span class="glyphicon glyphicon-ok" style="color: green"> На складе</span>';
                           }
                        },
                    
               // 'filter' => ['2'=> 'Заказано', '3' => 'На складе']
            ],
          //  'status.status',
          
                    'date_receive',

          
                    ],
            ]);
           ?>
        </div>
       
       
      
       
    </div>
</div>
