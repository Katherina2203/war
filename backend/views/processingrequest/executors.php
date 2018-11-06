<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
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
<div class="processingrequest-index">

    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
                    <?= $this->render('_searchreq', ['modelRequest' => $searchRequest]); ?>
            </div>
        </div>
    </div>

    <p>
        
    </p>
 <?php Pjax::begin(['id' => 'byexecutor']); ?>     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchRequest,// $searchModel,
     /*    'rowOptions' => function($model, $key, $index, $grid){
            if($model->requests->status == '0'){  // not active
                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->requests->status == '1'){  //active
                 return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }elseif($model->requests->status == '2'){ //cancel
                return ['style' => 'label label-default glyphicon glyphicon-time; color: #b2b2b2;']; //cancel f97704 - orange color:#c48044
            }elseif($model->requests->status = '3'){ //done
                return ['style' => 'color:#b2b2b2'];
            }
        },*/
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
           // ['class' => 'yii\grid\SerialColumn'],
          //  'idprocessing',
          //  'idrequest',
            [
                'attribute' => 'idrequest',
                'label' => '#Заявки',
              //  'contentOptions' => ['style' => 'max-width: 40px;'],
            ],
           [
                'attribute' => 'purchaseorder_count',
                'label' => 'Check active',
                 'format' => 'raw',
                'value' => function($data){
                  if($data->purchaseorder_count > '0'){
                    return '<span class="glyphicon glyphicon-plus"></span> '. $data->purchaseorder_count;
                  } else{
                        return Html::a('<span class="glyphicon glyphicon-plus"></span> '. $data->purchaseorder_count, ['processingrequest/additem', 'idrequest' => $data->idrequest]);
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
                'contentOptions' => ['style' => 'max-width: 190px;white-space: normal'],
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Описание',
                'value' => 'requests.description',
                'contentOptions' => ['style' => 'max-width: 380px;white-space: normal'],
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Количество',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>'. $data->requests->quantity .'</center></strong>';
                }
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Ожидаемая дата',
                'value' => 'requests.required_date'
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Заказчик',
                'value' => 'requests.iduser'
            ],
            [
                'attribute' => 'idrequest',
                'label' => 'Примечание',
                'value' => 'requests.note',
                'contentOptions' => ['style' => 'max-width: 70px;white-space: normal'],
            ],
            [   'attribute' => 'idrequest',
                'format' => 'raw',
                'label' => 'Статус',
                'filter' => Html::activeDropDownList($searchRequest, 'status', $gridColumns),
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
         /*   [
                'attribute' => 'idpurchasegroup',
                'value' => 'user.surname',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idpurchasegroup', ArrayHelper::map(\common\models\Users::find()->where(['role' => '2'])->asArray()->all(), 'surname', 'name'), ['class' => 'form-control', 'prompt' => 'Выберите исполнителя'])
            ],*/
            
            
       //     'created_at',
            
           
            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {additem}', 
             'buttons' => [
                    'additem' => function ($url,$model,$key) {
                      $url = Url::to(['additem', 'idrequest' => $model->idrequest]);
                      return Html::a('<span class="glyphicon glyphicon-duplicate"></span>', $url,['title' => 'Добавить в базу']);
                    },
              ],
            ],
        ],
    ]); ?>
 <?php Pjax::end(); ?>   
</div>
