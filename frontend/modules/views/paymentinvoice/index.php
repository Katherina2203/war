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

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentinvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$gridColumns = [];

$this->title = 'Текущие счета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Текущие счета', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'id' => 'kv-grid-demo',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns'=>$gridColumns,
        'pjax' => true,
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'condensed' => false,
        'responsive' => false,
        'hover' => true,
        'bordered' => true,
     /*   'toolbar'=> [
            ['content'=>
            Html::button('<i class="glyphicon glyphicon-plus"></i> Текущий счет', [
                'type'=>'button', 
                'title'=>'Создать счет', 
                'class'=>'btn btn-success', 
               // 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
                ]) . ' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['create'], ['data-pjax'=>0, 
                'class'=>'btn btn-default', 
                'title'=>'Reset Grid'])
            ],
       // '{export}',
       // '{toggleData}',
        ], */
   /*     'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=> $this->title,
        ],*/
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->date_payment == NULL){
                return ['style' => 'color:#ba1313'];
            }elseif($model->confirm == false){
                 return ['class' => 'warning'];
            }else{
                ['class' => 'default'];
           }
        },

        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],
               ['class' => 'kartik\grid\ExpandRowColumn',
                   
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
                ],
          //  'idpaymenti',
            [
                'attribute' => 'idsupplier',
               // 'value' => 'supplier.name',
                'value' => function ($model) {
                    return empty($model->idsupplier) ? '-' : $model->supplier->name;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', ArrayHelper::map(\common\models\Supplier::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите плательщика'])
            ],
            [
                'attribute' => 'invoice',
                'format' => 'raw',
                'value' =>function(Paymentinvoice $data){
                    return Html::a(Html::encode($data->invoice), Url::to(['itemsin', 'id' => $data->idpaymenti]));
                }
            ],

            'date_invoice',
            
            [
                'attribute' => 'idpayer',
               // 'value' => 'payer.name',
                'value' => function ($model) {
                    return empty($model->idpayer) ? '-' : $model->payer->name;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idpayer', ArrayHelper::map(\common\models\Payer::find()->select(['idpayer', 'name'])->all(), 'idpayer', 'name'),['class'=>'form-control','prompt' => 'Выберите плательщика'])
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'date_payment',
                'vAlign' => 'middle',
              
                'editableOptions' => [
                    'inputType' => Editable::INPUT_DATE,
                    'asPopover' => true,
                   // 'size' => 'md',
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
                'editableOptions' => [
                    'asPopover' => false,
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => [0 => 'Не подтверждено', 1 => 'Подтверждено', 2 => 'Отмена'],
                    'displayValueConfig'=> [
                        '0' => '<span style="color: grey"><i class="glyphicon glyphicon-hourglass"></i> Не подтверждено</span>',
                        '1' => '<i class="glyphicon glyphicon-thumbs-up"></i> Подтверждено',
                        '2' => '<i class="glyphicon glyphicon-thumbs-down"></i> Отмена',
       
                    ],
                ],
                 'filter' => [0 => 'Не подтверждено', 1 => 'Подтверждено', 2 => 'Отмена'],
            /*    'value'=> function($model){
                    if($model->confirm == '1'){
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> Подтверждено</span>';
                    } elseif($model->confirm == '0'){
                       return '<span style="color: grey">Не подтверждено</span>';
                    }else{
                       return '<span class="glyphicon glyphicon-remove" style="color: red"> Отмена</span>';
                    };
                }*/
            ],

            // 'created_at',
            // 'updated_at',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
