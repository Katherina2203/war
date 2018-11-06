<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$gridColumns = [
    [
        'class'=>'kartik\grid\SerialColumn',
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'36px',
        'header'=>'',
        'headerOptions'=>['class'=>'kartik-sheet-style']
    ],
    [
    'class'=>'kartik\grid\EditableColumn',
    'attribute'=>'confirm',
   // 'pageSummary'=>'Total',
    'vAlign'=>'middle',
    'width'=>'210px',
         'data' => [0 => 'Не подтверждено', 1 => 'Подтверждено', 2 => 'Отмена'],
    'readonly'=>function($model, $key, $index, $widget) {
        return (!$model->status); // do not allow editing of inactive records
    },
    'editableOptions'=>[
       
                    'asPopover' => false,
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => [0 => 'Не подтверждено', 1 => 'Подтверждено', 2 => 'Отмена'],
                    'displayValueConfig'=> [
                        '0' => '<span style="color: grey"><i class="glyphicon glyphicon-hourglass"></i> Не подтверждено</span>',
                        '1' => '<i class="glyphicon glyphicon-thumbs-up"></i> Подтверждено',
                        '2' => '<i class="glyphicon glyphicon-thumbs-down"></i> Отмена',
       
                    ],
                ],
            /*=> function ($model, $key, $index) use ($colorPluginOptions) {
        return [
            'header'=>'Name', 
            'size'=>'md',
            'afterInput'=>function ($form, $widget) use ($model, $index, $colorPluginOptions) {
                return $form->field($model, "color")->widget(\kartik\widgets\ColorInput::classname(), [
                    'showDefaultPalette'=>false,
                    'options'=>['id'=>"color-{$index}"],
                    'pluginOptions'=>$colorPluginOptions,
                ]);
            }
        ];
    }*/
],
    [
    'class'=>'kartik\grid\EditableColumn',
    'attribute'=>'date_payment',    
    'hAlign'=>'center',
    'vAlign'=>'middle',
    'width'=>'9%',
    'format'=>'date',
    'xlFormat'=>"mmm\\-dd\\, \\-yyyy",
    'headerOptions'=>['class'=>'kv-sticky-column'],
    'contentOptions'=>['class'=>'kv-sticky-column'],
    'readonly'=>function($model, $key, $index, $widget) {
        return (!$model->status); // do not allow editing of inactive records
    },
    'editableOptions'=>[
        'header'=>'Publish Date', 
        'size'=>'md',
        'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
        'widgetClass'=> 'kartik\datecontrol\DateControl',
        'options'=>[
            'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
            'displayFormat'=>'dd.MM.yyyy',
            'saveFormat'=>'php:Y-m-d',
            'options'=>[
                'pluginOptions'=>[
                    'autoclose'=>true
                ]
            ]
        ]
    ],
],
    [
        'class'=>'kartik\grid\ActionColumn',
      //  'dropdown'=>$this->dropdown,
        'dropdownOptions'=>['class'=>'pull-right'],
        'urlCreator'=>function($action, $model, $key, $index) { return '#'; },
        'viewOptions'=>['title'=>'This will launch the book details page. Disabled for this demo!', 'data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'This will launch the book update page. Disabled for this demo!', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['title'=>'This will launch the book delete action. Disabled for this demo!', 'data-toggle'=>'tooltip'],
        'headerOptions'=>['class'=>'kartik-sheet-style'],
    ],
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'headerOptions'=>['class'=>'kartik-sheet-style'],
    ]
];

$this->title = 'Изменить статус заявок';
$this->params['breadcrumbs'][] = $this->title;
$getProject = ArrayHelper::map($modelTheme::find()->select(['name', 'idtheme'])->where(['status' => 'active']), 'idtheme', 'name');
$getUser = ArrayHelper::map($modelUser::find()->select(['id', 'surname'])->all(), 'id', 'surname');
?>
<div class="requests-changestatus">

    <h1><?= Html::encode($this->title) ?></h1>
  <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
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
           // ['class' => 'yii\grid\SerialColumn'],

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
          //  ],
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
                'contentOptions' => ['style' => 'max-width: 60px;white-space: normal'],
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
               
            ],
            [
                'attribute' => 'idproject',
                'value' => 'themes.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproject', $getProject,['class'=>'form-control','prompt' => 'Выберите проект']),
                'contentOptions' => ['style' => 'max-width: 150px;white-space: normal'],
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
                'vAlign' => 'middle',
              
                'editableOptions' => [
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => [0 => 'Не обработано', 1 => 'Активна', 2 => 'Отмена', '3' => 'Выполнено'],
                    'asPopover' => true,
                   // 'size' => 'md',
                    'displayValueConfig'=> [
                        '0' => '<span style="color: grey"> Не подтверждено</span>',
                        '1' => ' Подтверждено',
                        '2' => ' Отмена',
                        '3' => ' Выполнено',
       
                    ],
                    'options'=>[
                        'convertFormat'=>true, // autoconvert PHP format to JS format
                        'pluginOptions'=>['format'=>'php:Y-m-d'] 
                    //],
                       
                    ],
                ],
            ],
         /*   [
                'attribute' => 'idsupplier',
                'value' => function ($model) {
                    return empty($model->idsupplier) ? '-' : $model->supplier->name;
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', ArrayHelper::map(\common\models\Supplier::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите поставщика']),
            ],*/
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
             'template' => '{view} {update} {delete} {processingrequest} {changestatus}', 
             'buttons' => [
                   'processingrequest' => function ($url,$model,$key) {
                        $url = Url::to(['viewprocess', 'idrequest' => $key]);
                          return Html::a('<span class="glyphicon glyphicon-user"></span>', $url,
                                  ['title' => 'Посмотреть обработку заявок']
                                  );
                    },
                    'changestatus' => function ($url,$model,$key) {
                            $url = Url::to(['changestatus', 'idrequest' => $model->idrequest]);
                        return Html::a('<span class="glyphicon glyphicon-info-sign"></span>', $url,
                                  ['title' => 'Изменить статус']);
                    },
              ],
            ],
          //  ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
 
