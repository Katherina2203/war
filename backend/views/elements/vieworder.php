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
 <div class="row">
    <div class="col-sm-2">
        <div class="box box-solid box-success">
        <?php // Html::img(Yii::$app->request->baseUrl.'/images/'.$model->image, ['max-width'=>'300px', 'max-heigth' => '300px'],['alt' => 'image']);?>
            <?= Html::img(Url::to('@web/images/0306.jpg'.$model->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
        </div>
    </div>
     <div class="col-md-4">
        <div class="box box-solid box-success">

            <div class="box-body">
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
      </div>
    </div>
    
 <div class="col-md-6">
    <div class="box box-warning">
        <div class="box-header with-border"><h3 class="box-title">История заказа</h3></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderpur,
               // 'filterModel' => $searchModelout,
                'columns' => [
                    'idrequest',
                    [
                        'attribute' => 'idrequest',
                        'label' => 'Заказчик',
                        'value' => function($data){
                            return $data->requests->users->surname;
                        },
                    ],
                    [
                        'attribute' => 'idrequest',
                        'label' => 'Проект',
                        'value' => function($data){
                            return $data->requests->themes->name;
                        },
                    ],
                    [
                        'attribute' => 'idrequest',
                        'label' => 'Создано',
                        'format' => ['date', 'php:Y-m-d'],
                        'value' => function($data){
                            return $data->requests->created_at;
                        },
                    ],
                    [
                        'attribute' => 'idrequest',
                        'label' => 'Примечание',
                        'value' => function($data){
                            return $data->requests->note;
                        },
                    ],
                    [
                        'attribute' => 'idrequest',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value'=> function($model){
                            if($model->requests->status == '0'){ //not active
                               return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Не обработано</span>';
                            }elseif($model->requests->status == '1'){//active
                               return '<span class="glyphicon glyphicon-ok" style="color: green"> Активна</span>';
                            } elseif($model->requests->status == '2'){//cancel
                               return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"> Отменено</span>';
                            }elseif($model->requests->status == '3'){ //done
                               return '<span class="glyphicon glyphicon-saved" style="color:grey"> Выполнено</span>';
                            };
                        },
                        'filter' => ['0'=> 'Не обработано', '1' => 'Активна','2' => 'Отменено','3' => 'Выполнено']
                    ],
                ],
            ])?>
        </div>
      </div>
    </div> 
    
</div>
    <div class="row">
        <div class='col-sm-4'>
            <div class="box">
                <div class="box-header with-border"><h3 class="box-title">Цена</h3></div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
              //  'filterModel' => $searchModel2,
                 'columns' => [
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
        </div>
      
        
        <div class="col-md-8">
            <div class="box">
              <div class="box-header with-border"><h3 class="box-title">Поступление на склад</h3></div>
             <div class="box-body">
             <?= GridView::widget([
                'dataProvider' => $dataProvideracc,
                //'filterModel' => $searchModelacc,
                 'columns' => [
                    'idord',
                    [
                        'attribute' => 'quantity',
                        'format' => 'raw',
                        'value' => function($data){
                            return '<center><strong>' . $data->quantity . '</strong></center>';
                        }
                    ],
                    [
                       'attribute' => 'idprice',
                       'value' => 'prices.unitPrice',
                    ],
                    [
                        'attribute' => 'amount', 
                      /*  'value' => function($data){
                            return $data->amount;
                        }*/
                    ],
                    [
                       'attribute' => 'idinvoice',
                       'format' => 'raw',
                        'value' => function($data){
                            if($data->idinvoice == null){
                                return '№ ' . $data->account . ' от ' . $data->account_date;
                            }else{
                                return Html::a($data->idinvoice, ['paymentinvoice/view', 'id' => $data->idinvoice]);
                            }
                        }
                       // 'value' => 'paymentinvoice.invoicedate',
                     /*  'value' => function($model, $key, $index){
                            return Html::a($model->paymentinvoice->invoicedate, ['paymentinvoice/view', 'id' => $model->idpaymenti]);
                        },*/
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
                           }elseif($model->status == '4'){//active
                               return '<span class="glyphicon glyphicon-remove" style="color: #888"> Отмена</span>';
                           }
                        },
                    
               // 'filter' => ['2'=> 'Заказано', '3' => 'На складе']
            ],
                   'date_receive',
                    ],
            ]);
           ?>
            </div>
          </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">Взято со склада</h3></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderout,
                'filterModel' => $searchModelout,
                'columns' => [
                    'idofstock',
          //  'idelement',
            [
                'attribute' => 'iduser',
                'value' => 'users.surname',
                
                  'filter' => Html::activeDropDownList($searchModelout, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Select user']),
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
            'date',
         //   'idtheme',
            [
                'attribute' => 'idtheme',
                'value' => function($data){
                    return $data->themes->ThemList;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModelout, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'ThemList'),['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
            [
                'attribute' => 'idthemeunit',
                'value' => 'themeunits.UnitsListId',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModelout, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'UnitsListId'),['class'=>'form-control','prompt' => 'Выберите модуль']),
            ], 
            [
                'attribute' => 'idboart',
                'value' => function($data){
                    return $data->boards->BoardnameId;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModelout, 'idboart', ArrayHelper::map(\common\models\Boards::find()->select(['idboards', 'name'])->where(['discontinued' => '1'])->all(), 'idboards', 'BoardnameId'),['class'=>'form-control','prompt' => 'Выберите плату']),
            ], 
            'ref_of_board',

            ['class' => 'yii\grid\ActionColumn',
                'controller' => 'outofstock',
                ],
                ]
            ]) ?>
        </div>
    </div>
</div>
</div>
 