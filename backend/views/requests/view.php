<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\Requests */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-view">
     <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                
                <?php $form = ActiveForm::begin([
                        'action' => ['requests/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchRequest = new backend\models\RequestsSearch();
                     echo $form->field($searchRequest, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search in requests']);
                         ?>
                <?php ActiveForm::end(); ?>
                
            </div>
        </div>
    </div>
    <p>
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Начать обрабатывать', ['processingrequest/additem', 'idrequest' => $model->idrequest, 'idel' => $model->estimated_idel], ['class' => 'btn btn-warning'])?>
        <?= Html::button('Change status', ['value' => Url::to(['updatestatus', 'idrequest' => $model->idrequest]), 'class' => 'btn btn-primary', 'id' => 'modalButtonProduce']) ?>
        <?php Modal::begin([
                'header' => '<b>' . Yii::t('app', 'Update Request Status') . '</b>',
                'id' => 'modalProduce',
                'size' => 'modal-md',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
            ]);
                echo "<div id='modal-content'>".
                        $this->render('updatestatus', ['model' => $model, 'id' => $model->idrequest])
                . "</div>";

            Modal::end();?>
 <?php // Html::a('Change status', ['updatestatus', 'idrequest' => $model->idrequest], ['class' => 'btn btn-primary']) ?>
    </p>
   
    <h1>Заявка № <?= Html::encode($model->idrequest)?> - <?= Html::encode($this->title) ?></h1>

    
<div class="row">
    <div class="col-lg-3">
        <div class="box">
        <?= DetailView::widget([
                'model' => $model,
                'hover'=>true,
                'condensed'=>false,
             //   'mode'=>DetailView::MODE_VIEW,
              /*  'panel' => [
                    'type' => DetailView::TYPE_PRIMARY,
                    'heading' => $this->title,
                    'template' => [
                        '{title}',
                       // '{buttons}'
                    ]
                ],*/
                'attributes' => [
                    'idrequest',
                    [
                        'attribute' => 'idtype',
                        'value' => ArrayHelper::getValue($model, 'typeRequest.name')
                    ],
                    'name',
                    'description:ntext',
                    [
                        'attribute' => 'quantity',
                        'format'=> 'raw', 
                        'value'=> '<strong>'.$model->quantity.'</strong>', 
                        'displayOnly'=>true

                    ],
                    [
                        'attribute' => 'required_date',
                        'format' => 'raw',
                        'value' => $model->required_date != null ? ArrayHelper::getValue($model, 'required_date') : '<span class="label label-danger"> не указана</span>',
                    ],
                    [
                        'attribute' => 'idproduce',
                        'value' => $model->idproduce != null ? ArrayHelper::getValue($model, 'produce.manufacture') : '-',
                    ],
                    [
                        'attribute' => 'iduser',
                        'value' => ArrayHelper::getValue($model, 'users.surname')
                    ],
                    [
                        'attribute' => 'idproject',
                        'value' => ArrayHelper::getValue($model, 'themes.name')
                    ],
                    [
                        'attribute' => 'idboard',
                        'value' => ArrayHelper::getValue($model, 'board.name')
                    ],
                    [
                        'attribute' => 'idsupplier',
                        'value' => $model->idsupplier !=null ? ArrayHelper::getValue($model, 'supplier.name') : '-',
                    ],
      /*      [
                'attribute' => 'img',
                'value' => $model->img,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],*/
           
                    'created_at',
                    [
                        'attribute' => 'estimated_executor',
                       // 'label' => 'Исполнитель',
                        'value' => $model->estimated_executor != null ? ArrayHelper::getValue($model, 'users.surname') : '-', 
                    ],
                    'note',
                    [
                        'attribute' => 'estimated_category',
                        'value' => $model->estimated_category !=null ? ArrayHelper::getValue($model, 'category.name'): '-',
                    ],
            
                    [  
                        'attribute' => 'status',
                        'label'=>'Актуальность',
                        'format'=>'raw',
                        'value'=> call_user_func(function($data){
                            if($data->status == '0'){ //not active
                               return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Не обработано</span>';
                            }elseif($data->status == '1'){//active
                               return '<span class="glyphicon glyphicon-ok" style="color: green"> Активна</span>';
                            } elseif($data->status == '2'){//cancel
                               return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"> Отменено</span>';
                            }elseif($data->status == '3'){ //done
                               return '<span class="glyphicon glyphicon-saved" style="color:grey"> Выполнено</span>';
                            }
                            
                        }, $model),
                    ],
                ],
            ]) ?> 
     <?= Html::img(Url::to(Yii::$app->request->baseUrl.'/images/no data.jpg'.$modelelement->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
        </div><!-- /end .box -->
      </div>
    <div class="col-lg-8">
        <div class="box">
          <div class="box-header"><h3>Описание в базе</h3></div>
            <?php Pjax::begin(['id' => 'element-view']); ?>    
                <?= GridView::widget([
                    'dataProvider' => $dataProviderel,
               // 'panel'=>['type'=>'primary', 'heading'=>'Согласовано'],
                    'columns' => [
                        [
                            'attribute' =>  'box',
                           // 'value' => 'elements.name',
                            'contentOptions'=>['style'=>'width: 50px;'],
                        ],
                        'idelements',
                        [
                            'attribute' => 'name',
                            'label' => 'Номинал',
                            'format' => 'raw',
                            'value' => function($data){
                                return Html::a($data->name, ['elements/view', 'id' => $data->idelements]);
                            },
                        ],
                        [
                            'attribute' => 'nominal',
                            'label' => 'Описание',
                        ],
                         [
                            'attribute' => 'idcategory',
                            'label' => 'Категории',
                            'value' => function ($model) {
                                return empty($model->category->name) ? '-' : $model->category->name;
                            },
                        ],
                        [
                            'attribute' => 'idproduce',
                            'value' => function ($model) {
                                return empty($model->produce->manufacture) ? '-' : $model->produce->manufacture;
                            },
                         //   'filter' => Html::activeDropDownList($searchModel, 'idproduce', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->indexBy('idpr')->all(), 'idpr', 'manufacture'),['class'=>'form-control','prompt' => 'Выберите производител']),
                        ],

                   

               /*     ['class' => 'yii\grid\ActionColumn',
                     'controller' => 'elements',
                     'contentOptions' => ['style' => 'width:45px;'],

                     'template' => '{view} {update} {viewprice}', 
                     'buttons' => [
                           'viewprice' => function ($url, $model) {
                          $url = Url::to(['elements/viewprice', 'idelement' => $model->elements->idelements]);
                            return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                                    ['title' => 'Посмотреть цены']
                                    );
                        },
                      ],
                    ],*/
                    ],
                ]); ?>
            <?php Pjax::end(); ?>    
        </div>
    </div>
    <div class="col-lg-4">
        <div class="box">
            <div class="box-header"><h3>Согласованное с заказчиком</h3></div>
                <?= DetailView::widget([
                  'model' => $modelorder,
                  'condensed'=>false,
                  'attributes' => [
                      [
                          'attribute' => 'quantity',
                          'format'=>'raw', 
                         // 'value'=>'<strong style="border: 1px solid red">'.$modelorder->quantity.'</strong>', 
                           'value' => $modelorder->quantity != null ? $modelorder->quantity : '-'
                           
                          
                         // 'displayOnly'=>true,
                         //  'inputContainer' => ['class'=>'col-sm-6'] 
                      ],
                      [
                        'attribute' => 'date',
                        'format' => 'raw',
                        'value'=> $modelorder->date != null ? $modelorder->date : '-',
                        
                        //  'value'=> $modelorder->date != null ? $modelorder->date : '-', 
                      ],

                  ],
              ]) ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="box">
        <div class="box-header"><h3>Подтверждение оплаты руководством</h3></div>
            <?= DetailView::widget([
                 'model' => $modelinvoice,
                 'attributes' => [
                 [
                   //  'class' => 'kartik\grid\DataColumn',
                     'attribute' => 'confirm',
                     'label' => 'Счет утвержден',
                     'format'=>'raw',
                /*     'value'=> $modelinvoice->confirm ? 
                          '<span class="label label-success">Подтвержен</span>' : '<span class="label label-danger">Нет данных</span>',
                    // 'type'=>DetailView::INPUT_SWITCH,
                     'widgetOptions'=>[
                              'pluginOptions'=>[
                                       '1'=>'Подтвержен',
                                       '0'=>'Нет данных',
                                       '2'=>'Отбой',
                                     ]
                     ]*/
                   /* 'value'=> function($modelinvoice){
                            if($modelinvoice->confirm == '0'){ //not active
                               return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Нет данных</span>';
                            }elseif($modelinvoice->confirm == '1'){//active
                               return '<span class="glyphicon glyphicon-ok" style="color: green"> Подтвержен</span>';
                            } elseif($modelinvoice->confirm == '2'){//cancel
                               return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"> Отбой</span>';
                            };
                    },*/
                 ],
                 [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'date_payment',
                    'label' => 'Дата оплаты',
                    'format'=>'raw',
                    'value'=> $modelinvoice->date_payment != null ? $modelinvoice->date_payment : '-', 
                 ],
                 ],
             ]);?>
      
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="box">
            <div class="box-header"><h3>Состояние заказа</h3></div>
                <?php Pjax::begin(['id' => 'accounts-view']); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvideracc,
                    //  'filterModel' => $searchModel2,
                        'columns' => [
                            'idord',
                            'quantity',
                            [
                                'attribute' => 'idprice',
                                 'value' => function(\common\models\Accounts $accounts){
                                  return implode(', ', ArrayHelper::map($accounts->getPrices()->all(), 'idpr', 'unitPrice'));
                                  // return $accounts->getPrices()->all();
                                }
                            ],
                            [
                                'attribute' => 'idprice',
                                'label' => 'За ед.товара',
                                 'value' => function(\common\models\Accounts $accounts){
                                  return implode(', ', ArrayHelper::map($accounts->getPrices()->all(), 'idpr', 'forUP'));
                                  // return $accounts->getPrices()->all();
                                }
                            ],
                            'amount',
                            [
                                'attribute' =>  'idinvoice',
                                'format' => 'raw',
                                'value' => function($data){
                                    if($data->idinvoice == null){
                                        return '№ ' . $data->account . ' от ' . $data->account_date;
                                    }else{
                                        return Html::a('№' . $data->paymentinvoice->invoice . ' от '. $data->paymentinvoice->date_invoice, ['paymentinvoice/itemsin', 'idinvoice' => $data->idinvoice]);
                                    }
                                }
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
                            [
                                'attribute' => 'date_receive',   
                                'label' => 'Ожид. дата от постащика',
                                'format' => 'raw',
                               // 'value'=>'<strong>'.$modelacc->date_receive.'</strong>',

                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {receipt}',
                                'buttons' => [
                                   'receipt' => function ($url,$model,$key) {
                                        $url = Url::to(['elements/tostock', 'idel' => $key]);
                                         $model->status == '2' ? Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара']) : '';
                                    },
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'receipt') {
                                            $url ='elements/tostock?idel='.$model->idel;
                                            return $url;
                                        }
                                    }
                                ],
                                  
                            ],
                        ],
                ]);
               ?>
            <?php Pjax::end(); ?>    
        </div>
    
    </div>
     
    </div> 
    <div class="row">
        <div class="col col-md-10">
            <div class="box">
                <div class="box-header"><h3>История заявки</h3></div>
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                            'dataProvider' => $dataProviderHistory,
                            'filterModel' => $searchModelHistory,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                               // 'idreqstatus',
                              //  'idrequest',
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'value' => function($model){
                                        if($model->status == '0'){ //not active
                                            return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Не обработано</span>';
                                        }elseif($model->status == '1'){//active
                                            return '<span class="glyphicon glyphicon-ok" style="color: green"> Активна</span>';
                                        }elseif($model->status == '2'){//active
                                            return '<span class="glyphicon glyphicon-remove" style="color: #888"> Отмена</span>';
                                        }elseif($model->status == '3'){
                                            return '<span class="glyphicon glyphicon-done" style="color: #888"> Выполнено</span>';
                                        }
                                    },
                                ],
                                'updated_at',
                                
                                [
                                    'attribute' => 'edited_by',
                                  //  'value' => 'users.surname'
                                ],
                                 'note',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <!-- end class row-->
</div>
<?php $this->registerJs(
 // Вызов модального окна формы заказа
   "$('#modalButtonProduce').on('click', function() {
        $('#modalProduce').modal('show')
            .find('#modal-content')
            .load($(this).attr('data-target'));
    });
  "
    );
?>
   
    

    
