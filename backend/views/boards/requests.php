<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;

use common\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];
 
$this->title = 'Журнал заявок';
$this->params['breadcrumbs'][] = $this->title;
//$getProject = ArrayHelper::map($modelTheme::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'name');
//$getUser = ArrayHelper::map($modelUser::find()->select(['id', 'surname'])->all(), 'id', 'surname');
?>
<div class="boards-requests">
    <?php Pjax::begin(['id' => 'requests']); ?>    
        <?= GridView::widget([
            'dataProvider' => $dataProviderreq,
            'filterModel' => $searchModelrequest,
          //  'showFooter' => true,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
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
            'columns' => [
                'idrequest',
                [
                    'attribute' => 'name',
                    'format'=>'raw',
                    'value' => function ($model, $key, $index) { 
                        return Html::a($model->name, ['view', 'id' => $model->idrequest]);
                    },
                   'contentOptions' => ['style' => 'max-width: 190px;white-space: normal'],
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
                    },
                    'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
                ],
                [
                    'attribute' =>  'iduser',
                    'value' => 'users.surname',
                    'format' => 'raw',
                    'filter' => Html::activeDropDownList($searchModelrequest, 'iduser', ArrayHelper::map(Users::find()->select(['id', 'surname'])->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите заказчика'])
                ],
                [
                    'attribute' => 'created_at',
                   // 'label' => Yii::t('requests/view', 'required'),
                    'format' => ['date', 'php:Y-m-d'],
                ],
                [
                    'attribute' => 'required_date',
                   // 'label' => Yii::t('requests/view', 'required'),
                    'format' => ['date', 'php:Y-m-d'],
                ],
                [
                    'attribute' => 'note',
                    'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
                ],
                [   'attribute' => 'status',
                    'format' => 'html',
                  //  'filter' => Html::activeDropDownList($searchModel, 'status', $gridColumns),
                    'value'=> function($model){
                        if($model->status == '0'){ //not active
                           return '<span class="label label-warning" style="color: #d05d09"><span class="glyphicon glyphicon-unchecked"> Не обработано</span></span>';
                        }elseif($model->status == '1'){//active
                           return '<span class="label label-success"><span class="glyphicon glyphicon-ok"> Активна</span></span>';
                        } elseif($model->status == '2'){//cancel
                           return '<span class="label label-danger" style="color: #b02c0d"><span class="glyphicon glyphicon-remove"> Отменено</span></span>';
                        }elseif($model->status == '3'){ //done
                           return '<span class="glyphicon glyphicon-saved" style="color:grey"> Выполнено</span>';
                        };
                    },
                    'filter' => ['0'=> 'Не обработано', '1' => 'Активна','2' => 'Отменено','3' => 'Выполнено']
                ],

                ['class' => 'yii\grid\ActionColumn',
                // 'contentOptions' => ['style' => 'width:45px;'],
                 'contentOptions' => ['style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;'],
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
 