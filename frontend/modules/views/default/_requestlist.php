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
        'pjax' => true,
      //  'columns' => $gridColumns,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
            'idrequest',
            [
                'attribute' => 'name',
                'format'=>'raw',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idrequest]). '<br><span class="product-description">' .
                     Html::encode($model->description). '</span>';
                },
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
                       return '<span class="label label-warning glyphicon glyphicon-unchecked"> Не обработано</span>'; // style="color: #d05d09"
                    }elseif($model->status == '1'){//active
                       return '<span class="label label-success glyphicon glyphicon-ok"> Активна</span>';
                    } elseif($model->status == '2'){//cancel
                       return '<span class="label glyphicon glyphicon-remove" style="color: #b02c0d"> Отменено</span>';
                    }elseif($model->status == '3'){ //done
                       return '<span class="label glyphicon glyphicon-saved" style="color:grey"> Выполнено</span>';
                    };
                },
                'filter' => ['0'=> 'Не обработано', '1' => 'Активна','2' => 'Отменено','3' => 'Выполнено']
            ],

         /*   ['class' => 'yii\grid\ActionColumn',
           //  'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{processingrequest}', 
              'buttons' => [
                   'processingrequest' => function ($url,$model,$key) {
                  $url = Url::to(['viewprocess', 'idrequest' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', $url,
                            ['title' => 'Посмотреть обработку заявок']
                            );
                },
              ],
            ],*/
        ],
    ]); ?>
<?php Pjax::end(); ?>

 
