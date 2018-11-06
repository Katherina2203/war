<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

use common\models\Processingrequest;
use common\models\Requests;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = 'Назначение исполнителя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-checkprocess">
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    
    <?php Modal::begin([
            'header' => '<b>' . Yii::t('app', 'Назначить исполнителя') . '</b>',
            'id' => 'modalProcess',
            'size' => 'modal-md',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
            ]);
                echo "<div id='modal-contentProcess'>".
                        $this->render('editprocess', ['model' => new Processingrequest()])
                . "</div>";

    Modal::end();?>
    
<?php Pjax::begin(['id' => 'checkprocess']); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->status == '0'){  // not active
                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->status == '1'){  //active
                 return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }elseif($model->status == '2'){ //cancel
                return ['style' => 'label label-default glyphicon glyphicon-time; color: #b2b2b2;']; //cancel f97704 - orange color:#c48044
            }elseif($model->status == '3'){ //done
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
           // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'processing_count',
                'label' => 'Check Executor',
                'format' => 'raw',
                'value' => function($model){
                /*  if($data->processing_count > '0'){
                    return '<span class="glyphicon glyphicon-user"></span> '. $data->processing_count;
                  } else{
                        return Html::a('<span class="glyphicon glyphicon-user"></span> '. $data->processing_count, ['requests/viewprocess', 'idrequest' => $data->idrequest, 'iduser' => yii::$app->user->identity->id]);
                    } */
                     if($model->status == '2'){
                        return '<div data-toggle="tooltip" data-placement = "tooltip" title="Status close"><span class="glyphicon glyphicon-remove"></span></div>';
                    }else{
                        if($model->processing_count > '0'){
                                return '<div data-toggle="tooltip" data-placement = "tooltip" title="'.$model->users->surname.'"><span class="glyphicon glyphicon-user"></span></div><div class="tooltip-block"></div> '. $model->processing_count;
                        } else{
                              return Html::a('<span class="glyphicon glyphicon-user"></span> '. $model->processing_count, ['requests/viewprocess', 'idrequest' => $model->idrequest, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success', 'id' => 'modalButtonProcess']);
                          } 
                    }   
                },
                'filter' => ['0'=> 'Нет исполнителя', '1' => 'Есть исполнитель'],        
            ],
            'idrequest',
            [
              'attribute' => 'name',
              'format'=>'raw',
               'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idrequest]);
                },
                'contentOptions' => ['style' => 'max-width: 210px;white-space: normal'],
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['style' => 'max-width: 310px;white-space: normal'],
            ],
           
            [
                'attribute' => 'quantity',
                'format'=>'raw',
                'value'=>function ($data){
                    return '<strong>'.$data->quantity.'</strong>';
                },
                'contentOptions' => ['style' => 'max-width: 60px; white-space: normal'],
            ],
            [
                'attribute' =>  'iduser',
                'value' => 'users.surname',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите заказчика'])
            ],
            [
                'attribute' => 'required_date',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'idproject',
                'value' => 'themes.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproject', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
                'contentOptions' => ['style' => 'max-width: 150px;white-space: normal'],
            ],
          /*  [
                'attribute' => 'note',
                'value' => function($data){
                    return(empty($model->idsupplier)) ? '-' : $model->suppliers->name;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', ArrayHelper::map(\common\models\Supplier::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите поставщика']),
            ],*/
            [
                'attribute' => 'note',
                'contentOptions' => ['style' => 'max-width: 150px;white-space: normal'],
            ],
            [
                'attribute' => 'estimated_executor',
                'format'=>'raw',
                'value' => function($model){
                   // return (empty($model->estimated_executor) or $model->estimated_executor == 0) ? '-' : $model->users->surname;
                    return $model->estimated_executor;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'estimated_executor', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->where(['role' => '2'])->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите заказчика'])
            ],
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
             //   'filter' => ['0'=> 'Не обработано', '1' => 'Активна','2' => 'Отменено','3' => 'Выполнено']
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
          //  ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>

<?php $this->registerJs(
   "$('#modalButtonProcess').on('click', function() {
        $('#modalProcess').modal('show')
            .find('#modal-contentProcess')
            .load($(this).attr('data-target'));
    });
  "
    );
?>