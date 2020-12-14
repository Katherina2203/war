<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Tabs;

//use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Supplier; 
use common\models\Produce;
use common\models\Themes;
use common\models\Users;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];
$getProject = ArrayHelper::map(Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active']), 'idtheme', 'name');
$getUser = ArrayHelper::map(Users::find()->select(['id', 'surname'])->all(), 'id', 'surname');

$this->title = 'Журнал заявок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-index">
    
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="<?= Url::to(['requests/index']) ?>"><?= 'All requests' ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['requests/myrequests', 'iduser' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-user"></span> <?=  'My Requests' ?></a></li>
       
    <!--    <li role="presentation" ><a href="#"><span class="glyphicon glyphicon-comment"></span> <?php //  'Created by {name}'?></a></li>-->
    </ul>
 
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
  
    <p>
         <?php echo Html::tag('span',
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']),
                    [
                        'title'=> yii::t('app', 'Создать заявку'),
                        'data-toggle'=>'tooltip',
                        'style'=>' cursor:pointer;color:red'
                    ]);?>
    </p>
    
  <?php Pjax::begin(['id' => 'requests']); ?>    
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
        'columns' => [
            'idrequest',
         /*   [
                'attribute' => 'processing_count',
                'label' => 'исполн',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->processing_count, ['processingrequest/createExecute', 'idrequest' => $data->idrequest]);
                },
            ],*/
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
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'iduser', $getUser,['class'=>'form-control','prompt' => 'Выберите заказчика'])
            ],
            [
                'attribute' => 'required_date',
                'format' => ['date', 'php:Y-m-d'],
                'value' => $model->required_date != null ? $model->required_date : NULL,
            ],
            [
                'attribute' => 'idproject',
                'value' => 'themes.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproject', $getProject,['class'=>'form-control','prompt' => 'Выберите проект']),
                'contentOptions' => ['style' => 'max-width: 150px;white-space: normal'],
            ],
        
         /*   [
                'attribute' => 'idproduce',
                'value' => 'produce.manufacture',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->all(), 'idpr', 'manufacture'),['class'=>'form-control','prompt' => 'Выберите производител']),
            ],*/
            [
                'attribute' => 'note',
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
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
