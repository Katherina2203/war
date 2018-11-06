<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\grid\ActionColumn;
use yii\widgets\InputWidget;
use yii\data\ActiveDataProvider;
use kartik\editable\Editable;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\Accounts;
use common\models\Paymentinvoice;
use backend\models\AccountsSearch;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

/*$gridColumns = [
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
 * */

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentinvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$gridColumns = [];

$this->title = 'Текущие счета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-index">
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
             </div>
        </div>
    </div>
    <p>
        <?php echo Html::a('Создать счет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'paymentinvoice']); ?>    
    <?= GridView::widget([
       // 'id' => 'id-paymentinvoice-index',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
     //   'columns'=>$gridColumns,
        'pjax' => true,
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'condensed' => false,
        'responsive' => false,
        'hover' => true,
        'bordered' => true,
        'floatHeader' => true,
     //   'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'toolbar'=> [
            ['content'=>
          //  Html::button('<i class="glyphicon glyphicon-plus"></i> Создать счет', [
           //     'type'=>'button', 
            //    'title'=>'Создать счет', 
          //      'class'=>'btn btn-success', 
               // 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
           //     ]) . ' '.
            Html::a('<i class="glyphicon glyphicon-plus"></i> Создать счет', ['create'], ['data-pjax'=>0, 
                'class'=>'btn btn-success', 
                'title'=>'Создать счет'])
            ],
       // '{export}',
       // '{toggleData}',
        ], 
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->date_payment == NULL & $model->confirm == false){ //еще нет оплаты
                return ['class' => 'info', 'style' => 'color:#ba1313'];
            }elseif(($model->date_payment != NULL & $model->confirm == false) || ($model->date_payment == NULL & $model->confirm == Paymentinvoice::CONFIRM_AGREE)){ //еще не подтвердил шеф   =0
                return ['class' => 'warning'];
            }elseif($model->confirm == Paymentinvoice::CONFIRM_CANCEL){  //отбой полный
                 return ['class' => 'danger'];//label label-default glyphicon glyphicon-time;
            }
            elseif($model->date_payment != NULL & $model->confirm == Paymentinvoice::CONFIRM_AGREE){
                return ['class' => 'default', 'style' => 'color: #b2b2b2'];
           }
        },
       'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],
             /*  ['class' => 'kartik\grid\ExpandRowColumn',
                   
                'value' => function($model, $key, $index, $column){
                            return GridView::ROW_COLLAPSED;
                           },
                'detail' => function($model, $key, $index, $column){
                           $searchModelacc = new AccountsSearch();
                           $modelel = new common\models\Elements();
                           $modelpr = new common\models\Prices();
                           $searchModelacc->idinvoice = $model->idpaymenti;
                         //  $dataProvideracc = $searchModelacc->search(Yii::$app->request->queryParams);
                            $query = Accounts::find()
                                    ->where(['idinvoice' => $model->idpaymenti]) //, 'idelem' => $modelel->idelements])
                                    ->With(['elements', 'prices']);
                            $dataProvideracc = new ActiveDataProvider([
                                'query' => $query,
            
                            ]);
                           return Yii::$app->controller->renderPartial('_detailinvoiceitems', [
                               'searchModelacc' => $searchModelacc,
                               'modelel' => $modelel,
                               'modelpr' => $modelpr,
                               'dataProvideracc' => $dataProvideracc,
                           ]);
                },
                ],*/
            'idpaymenti',
            [
                'attribute' => 'idsupplier',
                'format' => 'raw',
                'value' => function ($model) {
                    return empty($model->idsupplier) ? '-' : $model->supplier->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', ArrayHelper::map(\common\models\Supplier::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите плательщика'])
            ],
            [
                'attribute' => 'invoice',
                'format' => 'raw',
                'value' =>function($model){
                    return Html::a('№ ' . $model->invoice. ' от ' . $model->date_invoice, Url::to(['paymentinvoice/itemsin', 'idinvoice' => $model->idpaymenti]));
                }
            ],
          //  'date_invoice',
            [
                'attribute' => 'idpayer',
                'format' => 'raw',
                'value' => function ($model) {
                    return empty($model->idpayer) ? '-' : $model->payer->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'idpayer', ArrayHelper::map(\common\models\Payer::find()->select(['idpayer', 'name'])->all(), 'idpayer', 'name'),['class'=>'form-control','prompt' => 'Выберите плательщика'])
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'date_payment',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'inputType' => Editable::INPUT_DATE,
                    'asPopover' => true,
                    'formOptions' => ['action' => ['/site/confirm']],
                    'options'=>[
                        'convertFormat'=>true, // autoconvert PHP format to JS format
                        'pluginOptions'=>['format'=>'php:Y-m-d'] 
                    //],
                    ],
                ],
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'confirm', 
                'format'=>'raw',
                'value'=> function($model){
                    if($model->confirm == '0'){ //not active
                       return '<span class="glyphicon glyphicon-hourglass" style="color: #d05d09"> Не подтверждено</span>';
                    }elseif($model->confirm == '1'){//active
                       return '<span class="glyphicon glyphicon-thumbs-up" style="color: green"> Подтверждено</span>';
                    } elseif($model->confirm == '2'){//cancel
                       return '<span class="glyphicon glyphicon-thumbs-down" style="color: #b02c0d"> Отменено</span>';
                    }
                },
                'editableOptions' => [
                    'asPopover' => false,
                    'formOptions' => ['action' => ['/site/confirm']],
                    'data' => [0 => 'Не подтверждено', 1 => 'Подтверждено', 2 => 'Отмена'],
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'displayValueConfig'=> [
                        '0' => '<span style="color: grey"><i class="glyphicon glyphicon-hourglass"></i> Не подтверждено</span>',
                        '1' => '<i class="glyphicon glyphicon-thumbs-up"></i> Подтверждено',
                        '2' => '<i class="glyphicon glyphicon-thumbs-down"></i> Отмена',
                    ],
                ],
                'filter' => ([0 => 'Не подтверждено', 1 => 'Подтверждено', 2 => 'Отмена']),
             ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  <?php Pjax::end(); ?>
</div>
