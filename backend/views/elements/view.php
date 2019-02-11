<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\detail\DetailView;
use dmstr\widgets\Alert;
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
<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#quickorder").on("pjax:end", function() {
            $.pjax.reload({container:"#historyorder"});  //Reload GridView
            });
            
            if ($.pjax.("#historyorder").val() != empty ) { 
                $("#infobox").hide();
            } else {
                $("#infobox").show();
       
        });
        });'
    );
?>

<div class="elements-view">
    <p>
         <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Позицию', ['create'], [ 'title'=>'Создать единицу товара', 'class' => 'btn btn-success']) ?>
    </p>
<div class="row">
    <div class="col-md-10">
        <div class="box box-success">
            <div class="box-header with-border"><span>Item: </span><h2 class="box-title"><?= $model->name?></h2></div>
            <div class="box-body">
                <div class="col-md-2">
                        <div class="box box-solid box-success">
                        <?php // Html::img(Yii::$app->params['uploadPath'] = \yii::$app->basePath . '/web/images/capacitor/' . $model->image, ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image'])?>
                         <?= Html::img(Yii::getAlias('@web').'/images/' . $model->image, ['width'=>'200', 'heigth' => '200'],['alt' => 'image'])?>
                        </div>
                </div>
                <div class="col-md-6">
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->idelements], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->idelements], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('<i class="glyphicon glyphicon-list"></i>Заказать', 
                                ['orderquick', 'iduser' => yii::$app->user->identity->id, 'idel' => $model->idelements], 
                                [ 'title'=>'Создать заявку этого товара', 'class' => 'btn btn-warning'])
                        ?>
                        <?= Html::a('<i class="glyphicon glyphicon-minus"></i> Взять со склада', 
                                ['createfrom', 'iduser' => yii::$app->user->identity->id, 'idel' => $model->idelements], 
                                [ 'title'=>'Создать единицу товара', 'class' => 'btn btn-info'])
                        ?>
                        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Вернуть на склад', 
                                ['createreturn', 'iduser' => yii::$app->user->identity->id, 'idel' => $model->idelements], 
                                [ 'title'=>'Создать единицу товара', 'class' => 'btn btn-default'])
                        ?>

                    </p>
                    <div class="box box-solid box-success">
                        <?= DetailView::widget([
                            'model' => $model,
                            'condensed'=>false,
                            'attributes' => [
                                'idelements',
                                /*    [
                                     'attribute' => 'image',
                                     'value' => Yii::getAlias('@web').'/images/' . $model->image,
                                     //  return $model->image;
                                  //   },
                                     'format' => ['image',['width'=>'100','height'=>'100']],
                                 ],*/
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
                                 /*   'value' => function($model){
                                        return Html::a((ArrayHelper::getValue($model, 'category.name_ru')), ['category/items', 'id' => $model->idcategory]);
                                    }*/
                                ],
                                'created_at',
                                'updated_at',
                                [
                                    'attribute' => 'active',
                                    'label'=>'Актуальность',
                                    'format'=>'raw',
                                    'value'=>$model->active ==1 ? '<span class="label label-success" >Актуально</span>' : '<span class="label label-danger">Устарело</span>',
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
                <div class="col-md-3 request">
                    <h3 class="box-title">Создать заявку быстро</h3>
                    <div class="box-body">
                        <?php Pjax::begin(['id' => 'quickorder']); ?>
                            <?= $this->render('_formquick', [
                                        'model' => $modelrequests,
                            ]) ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div><!-- /end .box-body -->
        </div><!-- /end .box -->
    </div><!-- /end .col-md-10 -->
</div><!-- /end .row -->

<div class="row">
    <div class="col-sm-7">
        <div class="box box-warning">
            <div class="box-header with-border"><h3 class="box-title">История заказа</h3></div>
            <div class="box-body">
                <div id="infobox">
                    <div class="pad margin no-print">
                        <div class="callout callout-warning">
                            <h4><i class="fa fa-info"></i> Обратите внимание!</h4>
                                История заявки будет отображаться, когда отдел закупок начнет ее обрабатывать
                        </div>
                    </div>
                </div>
                <?php Pjax::begin(['id' => 'historyorder']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderpur,
                   // 'filterModel' => $searchModelout,
                    'showOnEmpty' => false,
                    'emptyText' => '<table><tbody></tbody></table>',
                    'columns' => [
                        [
                            'attribute' => 'idrequest',
                            'format' => 'raw',
                            'value' => function($data){
                               return Html::a($data->idrequest, ['requests/view', 'id' => $data->idrequest]);
                            },
                        ],
                        [
                            'attribute' => 'idrequest',
                            'label' => 'Количество',
                            'format' => 'raw',
                            'value' => function($data){
                                return $data->requests->quantity;
                            }
                        ],
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
                <?php Pjax::end(); ?>
            </div>
        </div>
        </div> 
        <div class='col-sm-4'>
            <div class="box box-danger">
                <div class="box-header with-border"><h3 class="box-title">Недостачи по платам</h3></div>
                <div class="box-body">
                    <?php Pjax::begin(); ?>
                                <?= $this->render('_shortageby', [
                                            'model' => $modelShortage,
                                            'dataProviderShortage'=>$dataProviderShortage,
                                           // 'searchModelTheme'=>$searchModelBoard
                                ]) ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
    </div> 
</div>
<div class="row">
        <div class='col-sm-4'>
            <div class="box">
                <div class="box-header with-border"><h3 class="box-title">Цена</h3></div>
                 <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider2,
                      //  'filterModel' => $searchModel2,
                        'showOnEmpty' => false,
                        'emptyText' => '<table><tbody></tbody></table>',
                        'columns' => [
                            'idpr',
                            [
                                'attribute' =>  'unitPrice',
                                'format' => 'raw',
                                'value' => function($data){
                                       return $data->unitPrice. '/'. $data->forUP. '<br/><small style="color:grey">+'. $data->pdv . '</small>';
                                },
                            ],
                            'usd',
                            [
                                'attribute' => 'idsup',
                                'value' => 'supplier.name',
                             //    'filter' => Html::activeDropDownList($searchModel2, 'idsup', ArrayHelper::map(common\models\Supplier::find()->select(['idsupplier', 'name'])->indexBy('idsupplier')->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите поставщика']),
                                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => ['date', 'php:Y-m-d'],
                            ]
                            
                        ], 
                    ]);
                   ?>    
                </div>
            </div>
        </div>
      
        
        <div class="col-md-7">
            <div class="box box-info">
              <div class="box-header with-border"><h3 class="box-title">Поступление на склад</h3></div>
             <div class="box-body">
             <?= GridView::widget([
                'dataProvider' => $dataProvideracc,
                //'filterModel' => $searchModelacc,
                'showOnEmpty' => false,
                'emptyText' => '<table><tbody></tbody></table>',
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{receipt}',
                        'controller' => 'accounts',
                        'buttons' => [
                            'receipt' => function ($url,$model,$key) {
                                $url = Url::to(['createreceipt', 'idord' => $key, 'idel' => $model->idelem]);
                                return $model->status == '2' ? Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара'])
                                : '';
                            },
                        ],
                    ],
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
                                return Html::a('№' . $data->paymentinvoice->invoice . ' от '. $data->paymentinvoice->date_invoice, ['paymentinvoice/itemsin', 'idinvoice' => $data->idinvoice]);
                            }
                        }
                       // 'value' => 'paymentinvoice.invoicedate',
                     /*  'value' => function($model, $key, $index){
                            return Html::a($model->paymentinvoice->invoicedate, ['paymentinvoice/view', 'id' => $model->idpaymenti]);
                        },*/
                    ],
                    [
                                'attribute' =>  'idinvoice',
                                'label' => 'Supplier',
                                'format' => 'raw',
                                'value' => function($data){
                                    return empty($data->idinvoice) ? '-' : $data->paymentinvoice->supplier->name;
                                }
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
                    //],
                   
                 ],
                ]);
            ?>
            </div>
          </div>
        </div>

    </div>

<div class="row">
    <div class='col-sm-6'>
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">Вернули на склад</h3></div>
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderreceipt,
                //'filterModel' => $searchModelacc,
                    'showOnEmpty' => false,
                    'emptyText' => '<table><tbody></tbody></table>',
                    'columns' => [
                      //  'idreturn',
                        'quantity',
                        'created_at',
                    ],
                    ]);
                ?>
            </div>
        </div>
    </div>  
</div>
<div class="row">
    <div class='col-sm-12'>
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">Взято со склада</h3></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProviderout,
                'filterModel' => $searchModelout,
                'showOnEmpty' => false,
                'emptyText' => '<table><tbody></tbody></table>',
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
                //    return $data->themes->ThemList;
                return empty($data->idtheme) ? '-' : $data->themes->name;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModelout, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'ThemList'),['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
            [
                'attribute' => 'idthemeunit',
              //  'value' => 'themeunits.UnitsListId',
                'value' => function($data){
                    return empty($data->idthemeunit) ? '-' : $data->themeunits->nameunit;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModelout, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'UnitsListId'),['class'=>'form-control','prompt' => 'Выберите модуль']),
            ], 
            [
                'attribute' => 'idboart',
                'format' => 'raw',
                'value' => function($data, $url){
                    $url = Url::to(['boards/view', 'id' => $data->idboart]);
                    return html::a($data->boards->BoardnameId, $url);//$data->boards->BoardnameId = '0' ? '-' :
                },
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
</div>
