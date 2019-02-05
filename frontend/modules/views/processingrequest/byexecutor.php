<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcessingrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];
use common\models\Users;
use common\models\Processingrequest;
$this->title = 'Журнал заявок к обработке';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-byexecutor">

  

     <div class="search-form">
        <div class="box box-solid bg-gray-light" style="border: 1px solid #d2d6de;">
            <div class="box-body">
                <span>Поиск по:</span>
                <?php  echo $this->render('_searchrequests', ['modelrequest' => $searchrequest]); ?>
            </div>
        </div>
    </div>
    <p>
        
    </p>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'rowOptions' => function($model, $key, $index, $grid){
            if($model->requests->status == '0'){  // not active
                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->requests->status == '1'){  //active
                 return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }elseif($model->requests->status == '2'){ //cancel
                return ['style' => 'label label-default glyphicon glyphicon-time; color: #b2b2b2;']; //cancel f97704 - orange color:#c48044
            }elseif($model->requests->status = '3'){ //done
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
            [
                'attribute' => 'idrequest',
                'label' => '#Заявки',
            ],
            [
                'attribute' => 'purchaseorder_count',
                'label' => 'Check active',
                 'format' => 'raw',
                'value' => function($data){
                  if($data->purchaseorder_count > '0'){
                    return '<span class="glyphicon glyphicon-plus"></span> '. $data->purchaseorder_count;
                  } else{
                        return Html::a('<span class="glyphicon glyphicon-plus"></span> '. $data->purchaseorder_count, ['additem', 'idrequest' => $data->idrequest]);
                    } 
                },

            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Наименование',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->requests->name, ['requests/view', 'id' => $data->idrequest]);
                },
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Описание',
                'value' => 'requests.description',
                'contentOptions' => ['style' => 'max-width: 190px;white-space: normal'],
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Количество',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>'. $data->requests->quantity .'</center></strong>';
                },
                'contentOptions' => ['style' => 'max-width: 45px;white-space: normal'],
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Ожидаемая дата',
                'format' => 'raw',
                'value' => function($data){
                    $now = new \DateTime('now');
                    if($data->requests->status == '0'){
                        if($now->getTimestamp() > $data->requests->required_date){
                            return '<b style="color: orange">'.$data->requests->required_date . '<b>';
                        }
                    } if($data->requests->status == '3'){
                        return '<b style="color: #b02c0d">'.$data->requests->required_date . '<b>';
                    }else{
                        return $data->requests->required_date;
                    }
                   
                }
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Заказчик',
                'value' => function($model){
                    return $model->users->userName;
                }
            
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Поставщик',
                'value' => function($model){
                    return empty($model->supplier->idsupplier) ? '-' : $model->supplier->idsupplier;
                }
               
            ],
            [   'attribute' => 'idrequest',
                'format' => 'raw',
                'label' => 'Статус',
              //  'filter' => Html::activeDropDownList($searchModel, 'status', $gridColumns),
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
            'created_at',
            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{changestatus}', 
              'buttons' => [
                    'changestatus' => function ($url,$model,$key) {
                      $url = Url::to(['requests/updatestatus', 'idrequest' => $model->idrequest]);
                      return Html::a('<span class="glyphicon glyphicon-info-sign"></span>', $url,['title' => 'Изменить статус вручную']);
                    },
              
              ],
            ],
        ],
    ]); ?>
    
   
</div>
