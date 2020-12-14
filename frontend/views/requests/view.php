<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Requests */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-changestatus">
    <p>
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
    <h1>Заявка № <?= Html::encode($model->idrequest)?> - <?= Html::encode($this->title) ?></h1>
    
<div class="row">
    <div class="col-lg-3">
        <div class="box box-info">
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
                'format'=>'raw', 
                'value'=>'<strong>'.$model->quantity.'</strong>', 
                'displayOnly'=>true
                
            ],
            'required_date',
            [
                'attribute' => 'idproduce',
                'value' => $model->idproduce != null ? ArrayHelper::getValue($model, 'produce.manufacture') : '-',
            ],
            [ //who ordered
                'attribute' => 'iduser',
                'value' => ArrayHelper::getValue($model, 'users.surname'),
                
            ],
            [
                'attribute' => 'idproject',
                'value' => ArrayHelper::getValue($model, 'themes.name')
            ],
            [
                'attribute' => 'idsupplier',
                'value' => $model->idsupplier !=null ? ArrayHelper::getValue($model, 'supplier.name') : '-',
            ],
            'created_at',
            [
                'attribute' => 'estimated_executor',
               // 'label' => 'Исполнитель',
                'value' => $model->estimated_executor != null ? ArrayHelper::getValue($model, 'users.surname') : '-', 
                'visible' => \Yii::$app->user->can('users.surname'),
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
             /*   'view' => function($model){
                    if($model->status == '0'){
                        return '<span class="label label-warning" style="color: #d05d09">no active</span>';
                    }elseif($model->status == '1'){
                        return '<span class="label label-success" style="color: green"> active</span>';
                    }elseif($model->status == '2'){
                        return '<span class="label label-danger" style="color: #888"> cancel</span>';
                    }elseif($model->status == '3'){
                        return '<span class="label label-default">done</span>';
                    }
                }*/
            ],
        ],
    ]) ?> 
     <?= Html::img(Url::to(Yii::$app->request->baseUrl.'/images/no data.jpg'.$modelelement->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
    </div>
</div>
    <div class="col-lg-8">
        <div class="box box-primary">
          <div class="box-header"><h3>Описание в базе</h3></div>
          <?php Pjax::begin(['id' => 'elements-view']); ?>    
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
                    ],
                    [
                        'attribute' => 'nominal',
                        'label' => 'Описание',
                    ],
                     [
                        'attribute' => 'idcategory',
                        'label' => 'Категории',
                        'value' => empty('category.name') ? '-' : 'category.name',
                    ],
                    [
                        'attribute' => 'idproduce',
                        'value' => empty('produce.manufacture') ? '-' : 'produce.manufacture',
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
   
    
    
    <div class="col-lg-8">
        <div class="box">
            <div class="box-header"><h3>Состояние заказа</h3></div>
                <?php Pjax::begin(['id' => 'accounts-view']); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvideracc,
                    //  'filterModel' => $searchModel2,
                        'columns' => [
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
                               /* 'value' => function(\common\models\Accounts $invoice){
                                    return '№'.$invoice->idinvoice.' от '. $invoice->account_date;
                                //Html::a('№'.$invoice->idinvoice, ['id' => $invoice->idinvoice]);
                                }*/
                                'format' => 'raw',
                                'value' => function($data){
                                    if($data->idinvoice == null){
                                        return '№ ' . $data->account . ' от ' . $data->account_date;
                                    }else{
                                        return Html::a($data->idinvoice, ['paymentinvoice/view', 'id' => $data->idinvoice]);
                                    }
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
                                    }elseif($model->status == '4'){//cancel
                                        return '<span class="glyphicon glyphicon-remove" style="color: #888"> Отмена</span>';
                                    }
                                 },

                        // 'filter' => ['2'=> 'Заказано', '3' => 'На складе']
                            ],
                         //   'date_receive',
                            [
                                'attribute' => 'date_receive',   
                                'label' => 'Ожид. дата от постащика',
                                'format' => 'raw',
                               // 'value'=>'<strong>'.$modelacc->date_receive.'</strong>',

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
            <div class="box box-warning">
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

                               // ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <!-- end class row-->
</div>

   
    

    
