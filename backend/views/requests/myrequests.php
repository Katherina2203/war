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

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
$getProject = ArrayHelper::map($modelTheme::find()->select(['name', 'idtheme'])->where(['status' => 'active']), 'idtheme', 'name');
//$getProject = ArrayHelper::map(\common\models\Themes::find()->select(['name', 'idtheme'])->where(['status' => 'active'])->all(), 'idtheme', 'name');
$getSupplier = ArrayHelper::map($modelSupp::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name');
?>
<div class="requests-index">
  
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="<?= Url::to(['requests/index']) ?>"><?= 'All requests' ?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['requests/myrequests', 'iduser' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-user"></span> <?=  'My Requests' ?></a></li>
       <!-- <li role="presentation"><a href="<?= Url::to(['elements/view', 'id' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= 'Member View' ?></a></li>
        <li role="presentation" ><a href="#"><span class="glyphicon glyphicon-comment"></span> <?=  'Posts created by {name}'?></a></li>
    -->
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
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       // 'model' => $model,
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
        'showOnEmpty' => false,
        'emptyText' => '<table><tbody></tbody></table>',
        'pjax' => true,
        'pjaxSettings'=>[
                'neverTimeout'=>true,
                'beforeGrid'=>'My fancy content before.',
                'afterGrid'=>'My fancy content after.',
            ],
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
         /*   [
                'attribute' =>  'iduser',
                'value' => 'users.surname',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите заказчика'])
            ],*/
            [
                'attribute' => 'required_date',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'idproject',
                'value' => 'themes.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproject', $getProject,['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
            [
                'attribute' => 'idsupplier',
                'value' => 'supplier.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', $getSupplier,['class'=>'form-control','prompt' => 'Выберите поставщика']),
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
          //  ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
 
