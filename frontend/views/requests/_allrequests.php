<?php
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Supplier;


use backend\models\RequestsSearch;

    $searchModel = new RequestsSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],

        ];

        
?>
<?php Pjax::begin(); ?>
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->status == '0'){  // not active
                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->status == '1'){  //active
                 return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }elseif($model->status == '2'){ //cancel
                return ['style' => 'label label-default glyphicon glyphicon-time']; //cancel f97704 - orange color:#c48044
            }elseif($model->status = '3'){ //done
                return ['style' => 'color:#b2b2b2'];
            }
        },
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'resizableColumns'=>true,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'idrequest',
              'label' =>'#Заявки'
            ],
            [
              'attribute' => 'name',
              'format'=>'raw',
               'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idrequest]);
                },
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['style' => 'max-width: 380px;white-space: normal'],
            ],
            [
                'attribute' => 'quantity',
                'format'=>'raw',
                'value'=>function ($data){
                return '<strong>'.$data->quantity.'</strong>';
                }
            ],
            [
                'attribute' => 'required_date',
              //  'format' => ['date', 'php:Y-m-d'],
                'value' => function($model){
                    return empty($model->required_date) ? '-' : $model->required_date;
                }
            ],
            [
                'attribute' => 'idproject',
               // 'value' => 'themes.name',
                'value' => function ($model) {
                    return empty($model->idproject) ? '-' : $model->themes->name;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproject', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
       //     'type',
        /*  [
              'attribute' => 'type',
              'value' => 'type_of_products.name'
          ],*/
        //    'idelements',
           
         /*   [
                'attribute' => 'idproduce',
                'value' => 'produce.manufacture',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', Produce::find()->select(['manufacture', 'idpr'])->indexBy('idpr')->column(), ['class' => 'form-control', 'prompt' => 'Выберите производителя'])
            ],*/
            [
                'attribute' => 'idsupplier',
               // 'value' => 'supplier.name',
                'value' => function ($model) {
                    return empty($model->idsupplier) ? '-' : $model->supplier->name;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', Supplier::find()->select(['name', 'idsupplier'])->indexBy('idsupplier')->column(), ['class' => 'form-control', 'prompt' => 'Выберите поставщика'])
            ],
             [
                'attribute' =>  'iduser',
                'value' => 'users.surname',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите заказчика'])
            ],
            [   'attribute' => 'status',
                'format' => 'html',
                'value'=> function($model){
                    if($model->status == '0'){ //not active
                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Не обработано</span>';
                    }elseif($model->status == '1'){//active
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> Активна</span>';
                    } elseif($model->status == '2'){//cancel
                       return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"> Отменено</span>';
                    }elseif($model->status == '3'){ //done
                       return '<span class="glyphicon glyphicon-saved" style="color:grey"> Выполнено</span>';
                    };
                },
                'filter' => ['0'=> 'Не обработано', '1' => 'Активна','2' => 'Отменено','3' => 'Выполнено']
            ],
            [
                'attribute' => 'note',
                'contentOptions' => ['style' => 'max-width: 70px;white-space: normal'],
            ],
      /*      ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {processingrequest}', 
              'buttons' => [
                   'processingrequest' => function ($url,$model,$key) {
                    if(yii::$app->user->can('head')){
                  $url = Url::to(['viewprocess', 'idrequest' =>$key, 'iduser' => yii::$app->user->identity->id]);
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', $url,
                            ['title' => 'Посмотреть обработку заявок']
                            );
                   }
                },
              ],
            ],*/
        ],
    ]); ?>
<?php Pjax::end(); ?>

