<?php
use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;
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

    <h1>Заявка № <?= Html::encode($model->idrequest)?> - <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
 <div class="col-md-4">
     <h3 style="padding: 10px;">Заявка № <?= Html::encode($model->idrequest)?></h3>
    <?= DetailView::widget([
        'model' => $model,
        'hover'=>true,
        'condensed'=>false,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'idrequest',
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
                'value' => ArrayHelper::getValue($model, 'produce.manufacture')
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
                'value' => ArrayHelper::getValue($model, 'supplier.name')
            ],

            'img',
            'created_at',
          //  'updated_at',
            'note',
            [   'class' => 'kartik\grid\DataColumn',
                'attribute' => 'status',
                'label'=>'Актуальность',
                'format'=>'raw',
                'value'=> $model->status == 0 ? '<span class="label label-success">Не обработано</span>' : '<span class="label label-danger">Актуально</span>',
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
    <div class="col-sm-5">
        <h3> <?php // Html::encode($modelelement->name);?></h3>
        <?= DetailView::widget([
        'model' => $modelelement,
        'panel'=>['type'=>'primary', 'heading'=>'Состояние заказа'],
        'attributes' => [
            [
                'attribute' => 'idelements',
            ],
            'box',
            'name',
            'nominal',
            [
                'attribute' => 'idproduce',
                'value' => ArrayHelper::getValue($modelelement, 'produce.manufacture')
            ],
            [
                'attribute' => 'idcategory',
              //  'value' => ArrayHelper::getValue($model, 'category.name_ru')
            ],
        ],
    ]) ?>
    </div>
    <div class="col-sm-2">
        <?= Html::img(Url::to(Yii::$app->request->baseUrl.'/images/no data.jpg'.$modelelement->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
    </div>
    </div>

    <div class="row">
    <div class="col-md-3">
        <h3>Подтверждение оплаты</h3>
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
            ],
        ]);?>
    </div>
    
    <div class="col-md-8">
        <?= GridView::widget([
        'dataProvider' => $dataProviderorder,
        'filterModel' => $searchModelorder,
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'panel'=>['type'=>'primary', 'heading'=>'Согласовано'],
        'resizableColumns'=>true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->idrequest == '1'){
                return ['style' => 'color:#ba1313'];
            }else{
                 return ['class' => 'default'];
            }
        },
        'columns' => [
            'idelement',
            'quantity',
            'date',
            ['class' => 'yii\grid\ActionColumn',
            // 'controlers' => 'elements',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {viewprice}', 
             'buttons' => [
                   'viewprice' => function ($url,$model) {
                  $url = Url::to(['elements/viewprice', 'idelement' => $model->elements->idelements]);
                    return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url,
                            ['title' => 'Посмотреть цены']
                            );
                },
              ],
            ],
        ],
    ]); ?>
    </div>
    <div>
    <div class="col-md-8">
        <?= GridView::widget([
               'dataProvider' => $dataProvideracc,
             //  'filterModel' => $searchModel2,
            'panel'=>['type'=>'primary', 'heading'=>'Состояние заказа'],
              'columns' => [
            [
                'attribute' => 'idprice',
            ],
            'quantity',
            [
                'attribute' =>  'idinvoice',
                'value' => function($invoice){
                    return '№'.$invoice->idinvoice.' от '. $invoice->account_date;
                }
            ],
          //  'account_date',
            'amount',
            'idinvoice',
            'delivery', 
            [
                'attribute' => 'status',
               // 'label' => 'Стасус',
                'value' => ArrayHelper::getValue($model, 'status.status'),
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
    </div>

</div>
