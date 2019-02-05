<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProviderreq,
        'filterModel' => $searchModelreq,
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->status == '0'){  // not active
                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->status == '1'){  //active
                 return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }elseif($model->status == '2'){ //cancel
                return ['style' => 'label label-default glyphicon glyphicon-time; color: #b2b2b2;']; //cancel f97704 - orange color:#c48044
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
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
            'idrequest',
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

            'note',
            [   'attribute' => 'status',
                'format' => 'html',
              //  'filter' => Html::activeDropDownList($searchModel, 'status', $gridColumns),
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

            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {processingrequest}', 
              'buttons' => [
                   'processingrequest' => function ($url,$model,$key) {
                  $url = Url::to(['viewprocess', 'idrequest' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', $url,
                            ['title' => 'Посмотреть обработку заявок']
                            );
                },
              ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>

 
