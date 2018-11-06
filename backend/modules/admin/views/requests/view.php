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
<div class="requests-view">
    <p>
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
    <h1>Заявка № <?= Html::encode($model->idrequest)?> - <?= Html::encode($this->title) ?></h1>

    
<div class="row">
   
 <div class="col-lg-3">

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
            [
                'attribute' => 'iduser',
                'value' => ArrayHelper::getValue($model, 'users.surname')
            ],
            [
                'attribute' => 'idproject',
                'value' => ArrayHelper::getValue($model, 'themes.name')
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
            
            [   'class' => 'kartik\grid\DataColumn',
                'attribute' => 'status',
                'label'=>'Актуальность',
                'format'=>'raw',
                'value'=> 
                $model->status == 0 ? '<span class="warning" style="color: #d05d09">Не обработано</span>' : '<span class="success" style="color: green">Актуально</span>',
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
    ]) ?> </
     <?= Html::img(Url::to(Yii::$app->request->baseUrl.'/images/no data.jpg'.$modelelement->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
   
</div>
    <div class="col-lg-8">
        <div class="box">
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
                        'value' => 'category.name',
                    ],
                    [
                        'attribute' => 'idproduce',
                        'value' => 'produce.manufacture',
                       // 'format' => 'text',
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
            'attributes' => [
                [
                    'attribute' => 'quantity',
                    'format'=>'raw', 
                    'value'=>'<strong>'.$model->quantity.'</strong>', 
                    'displayOnly'=>true,
                   //  'inputContainer' => ['class'=>'col-sm-6'] 
                ],
                [
                    'attribute' => 'date',
                    'value'=> $modelorder->date != null ? $modelorder->date : '-', 
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
                     'class' => 'kartik\grid\DataColumn',
                     'attribute' => 'confirm',
                     'label' => 'Счет утвержден',
                     'format'=>'raw',
                     'value'=> $modelinvoice->confirm ? 
                          '<span class="label label-success">Подтвержен</span>' : '<span class="label label-danger">Нет данных</span>',
                    // 'type'=>DetailView::INPUT_SWITCH,
                     'widgetOptions'=>[
                              'pluginOptions'=>[
                                       '1'=>'Подтвержен',
                                       '0'=>'Нет данных',
                                       '2'=>'Отбой',
                                     ]
                     ]
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
                                    }elseif($model->status == '4'){//active
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
    
    <!-- end class row-->
</div>

   
    

    
