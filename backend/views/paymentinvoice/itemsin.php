
<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use backend\components\TotalColumn;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список позиций в счете';
$this->params['breadcrumbs'][] = ['label' => 'Текущие счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h2>Счет № <?= $modelpay->invoice . ' <small>от ' . $modelpay->date_invoice. '</small>' ?></h2>
   
    <div class="pad margin no-print">
        <div class="callout callout-info">
            <h4><i class="fa fa-info"></i> Обратите внимание!</h4>
            Сумма счета указана без НДС
        </div>
    </div>
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header"><span><?php // Html::img(Yii::getAlias('@web').'/images/suppliers/' . $modelpay->supplier->logo, ['width' => '120px'])?></span>
                    <?= $modelpay->supplier->name;?>
                <small class="pull-right">Date: <?php echo $modelpay->date_invoice;?></small>
                </h2>
            </div>
        </div>
        
        <div class="row invoice-info">
            <div class="row">
                <center><strong><?= 'Счет №'. $modelpay->invoice. ' от '.  $modelpay->date_invoice?></strong></center>
            </div>
            <p>
        <?= Html::a('Update', ['update', 'id' => $model->idinvoice], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idinvoice], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
            <div class="col-sm-4 invoice-col">
                <?= '<b>Поставщик:</b> <br/>' . $modelpay->supplier->name;//idpayer  ?><br/>
                <?= $modelpay->supplier->address;  ?><br/>
                <?= $modelpay->supplier->phone;  ?><br/>
            </div>
            <div class="col-sm-4 invoice-col">
                <?= '<b>Плательщик:</b> <br/>' . $modelpay->payer->name;//idpayer  ?><br/>
                Вул. Печенизька, 8, Киев, 04107<br/>
            </div>
           
            <div class="col-sm-4 invoice-col">
                <?=  '<b>' .yii::t('app', 'Approving') . ': </b>' ?>
                <p>  
                    <?php    
                        if($modelpay->confirm == '0'){
                            echo '<span>Не рассмотрено руководством</span>'; //button надо утвердить
                            echo Html::button('Approve invoice', ['value' => Url::to(['updateconfirm', 'id' => $modelpay->idpaymenti]), 'class' => 'btn btn-default', 'id' => 'modalButtonConfirm']);
                        }elseif($modelpay->confirm == '1'){
                            echo '<span>Утверждено руководством</span>';
                        }elseif($modelpay->confirm == '2'){
                            echo '<span>Отменено руководством</span>';
                        }
                    ?>
                    <?php // Html::a('Approve invoice', ['accounts/createitem', 'idinvoice' => $modelpay->idpaymenti], ['class' => 'btn btn-default']) ?>
                    <?php //Html::button('Approve invoice', ['value' => Url::to(['updateconfirm', 'id' => $modelpay->idpaymenti]), 'class' => 'btn btn-default', 'id' => 'modalButtonConfirm']) ?>
                    <?php Modal::begin([
                        'header' => '<b>' . Yii::t('app', 'Change status to approve invoice') . '</b>',
                        'id' => 'modalConfirm',
                        'size' => 'modal-md',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
                    ]);
                        echo "<div id='modal-content'>".
                                $this->render('updateconfirm', ['model' => $modelpay, $id = $modelpay->idpaymenti])
                            ."</div>";

                    Modal::end();?>
                </p>
              
                    
                <p> <?= '<b>' . yii::t('app', 'Date payment') . ': </b>'?>
                    <?php 
                        if($modelpay->date_payment == ''){
                            echo Html::a('Appoint date payment', ['createitem', 'date_payment' => $modelpay->date_payment], ['class' => 'btn btn-default']);
                        }else{
                                echo  '<b>'.$modelpay->date_payment.'</b>';
                               }
                            ?>
                </p>
            </div>
        </div>
        <div class="row">
             <p>
                    <?= Html::a('Добавить товар в счет', ['accounts/createitem', 'idinvoice' => $modelpay->idpaymenti], ['class' => 'btn btn-success']) ?>
                </p>
            <div class="col-xs-12">
                <?php Pjax::begin(); ?><?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showFooter' => true,
                //    'showPageSummary' => true,
                    'pjax'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'floatHeader' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'idord',
                        'idelem',
                        [
                            'attribute' => 'idelem',
                            'label' => 'Производитель',
                            'value' => function($data){
                    return $data->idelem;
                                // return $data->elements->manufacturerName;
                              //   return $data->produce->manufacture;
                            },
                            'contentOptions' => ['style' => 'max-width: 240px;white-space: normal'],
                        ],
                        [
                            'attribute' => 'idelem',
                            'label' => 'Название',
                            'format' => 'raw',
                         //   'value' => 'elements.name',
                            'value' => function ($model, $key, $index) { 
                                return Html::tag('span', 
                                            Html::a($model->elements->name, ['elements/view', 'id' => $model->idelem]), 
                                            [
                                                    'title'=> yii::t('app', 'Заказчик'). ': '.$model->idelem.', '. yii::t('app', 'Проект'). ': '. $model->idelem,
                                                    'data-toggle'=>'tooltip',
                                                    'style'=>' cursor:pointer;color:red'//text-decoration: underline;requests->getCustomer()    ...requests->getProject()
                                                
                                            ]);
                            },
                            'contentOptions' => ['style' => 'max-width: 140px;white-space: normal'],
                        ],
                        [
                            'attribute' => 'idelem',
                            'label' => 'Описание',
                            'value' => 'elements.nominal',
                            'contentOptions' => ['style' => 'max-width: 240px;white-space: normal'],
                        ],
                        [
                            'attribute' => 'quantity',
                            'format' => 'raw',
                            'value' => function($data){
                                return '<strong><center>' . $data->quantity . '</center></strong>';
                            }
                        ],
                        [
                            'attribute' => 'idprice',
                            'value' => function($data){
                                return $data->prices->price;
                            }
                        ],
                        [
                            'label' => 'Сумма без НДС',
                            'attribute' => 'amount',
                            'footer' => TotalColumn::pageTotal($dataProvider->models,'amount'),
                        ],
                        [
                         //   'class'=>'kartik\grid\FormulaColumn',
                            'label' => 'sum',
                            'attribute' =>'amount',
                          //  'footer'=>TotalColumn::pageTotal($dataProvider->models,'amount'),  //будет необходимо, когда добавляешь несколько строк с пдв и без
                            'pageSummary'=>true,
                          //  'pageSummaryFunc'=> GridView::F_AVG
                        ],
                        'delivery',
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function($model){
                                if($model->status == '2'){ //not active
                                   return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Закано</span>';
                                }elseif($model->status == '3'){//active
                                   return '<span class="glyphicon glyphicon-ok" style="color: green"> На складе</span>';
                                }elseif($model->status == '3'){
                                    return '<span class="glyphicon glyphicon-cancel" style="color: grey"> Отмена</span>';
                                }
                            },
                            'filter' => ['2'=> 'Заказано', '3' => 'На складе']
                        ],
                        'date_receive',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {editinvoice} {deletefrom} {receipt} {changeprice}',
                            'controller' => 'accounts',
                            'buttons' => [
                                'deletefrom' => function ($url,$model,$key) {
                                    $url = Url::to(['deletefrom', 'id' => $key]);
                                  
                                },
                                'editinvoice' => function ($url,$model,$key) {
                                    $url = Url::to(['editinvoice', 'id' => $key]);
                                    return $model->status == '2' ? Html::a('<span class="glyphicon glyphicon-edit"></span>', $url,['title' => 'Редактировать позицию в счете'])
                                    : '';
                                },
                                'receipt' => function ($url,$model,$key) {
                                    $url = Url::to(['elements/createreceipt', 'idord' => $key, 'idel' => $model->idelem]);
                                    return $model->status == '2' ? Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара'])
                                    : '';
                                },
                                'changeprice' => function ($url,$model,$key) {
                                    $url = Url::to(['prices/changeprice', 'idpr' => $model->idprice, 'idel' => $model->idelem]);
                                    return $model->status == '2' ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,['title' => 'Изменить цену в счете'])
                                    : '';
                                },       
                            ],
                        ],
                ],
            ]); ?>  <?php Pjax::end(); ?>
            </div>
            
            <div class="row">
                <div class="col-xs-6">
                    <p><b>Информация о поставщике: </b></p>
                    Менеджер: <?= $modelpay->supplier->manager;  ?><br/>
                    <?= $modelpay->supplier->phone;  ?><br/>
                   <?= $modelpay->supplier->website;  ?><br/>
                </div>
           
            
            
                <div class="col-xs-6">
                    <p>Сумма с НДС: 
                  <strong><?= 1.2*TotalColumn::pageTotal($dataProvider->models,'amount')?><strong>
                    
                    </p>
                    
                </div>
            </div>
            
            <div class="row no-print">
                
            </div>
    </section>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <?php Pjax::begin(); ?>

</div>
    <script type="text/javascript">
$(function () { 
            $("[data-toggle='tooltip']").tooltip(); 
          });
          $(function () { 
                $("[data-toggle='popover']").popover(); 
                    
            });
        });
    });
</script>

<?php $this->registerJs(
 // Вызов модального окна формы заказа
   "$('#modalButtonConfirm').on('click', function() {
        $('#modalConfirm').modal('show')
            .find('#modal-content')
            .load($(this).attr('data-target'));
    });
  "
    );
?>


     

