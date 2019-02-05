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

$this->title = 'Назначение исполнителя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-checkprocess">
  
    <h1><?= Html::encode($this->title) ?></h1>
  <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
           // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'processing_count',
                'label' => 'Check Executor',
                'format' => 'raw',
                'value' => function($data){
                  if($data->processing_count > '0'){
                    return '<span class="glyphicon glyphicon-user"></span> '. $data->processing_count;
                  } else{
                        return Html::a('<span class="glyphicon glyphicon-user"></span> '. $data->processing_count, ['requests/viewprocess', 'idrequest' => $data->idrequest, 'iduser' => yii::$app->user->identity->id]);
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
                'contentOptions' => ['style' => 'max-width: 180px;white-space: normal'],
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['style' => 'max-width: 280px;white-space: normal'],
            ],
           
            [
                'attribute' => 'quantity',
                'format'=>'raw',
                'value'=>function ($data){
                    return '<strong>'.$data->quantity.'</strong>';
                }
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
                    return (empty($model->estimated_executor) or $model->estimated_executor == 0) ? '-' : $model->users->surname;
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
 
