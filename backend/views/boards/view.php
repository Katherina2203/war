<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $model common\models\Boards */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-view">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border"><span>Номер платы: <strong><?= $model->idtheme. '-'. $model->idthemeunit. '-'. $model->idboards;?></strong></span>
                    <h4><i class="glyphicon glyphicon-hdd"></i> <?= Html::encode($this->title) ?></h4>
                    
                    <div class="box-tools pull-right">
                        <?= Html::a('Update', ['update', 'id' => $model->idboards], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                       'idboards',
                        [
                            'attribute' => 'idtheme',
                            'value' =>  ArrayHelper::getValue($model, 'themes.name'),
                        ],
                        [
                            'attribute' => 'idthemeunit',
                            'value' =>  ArrayHelper::getValue($model, 'themeunits.nameunit'),
                        ],

                        [
                            'attribute' => 'current',
                            'value' =>  ArrayHelper::getValue($model, 'users.surname'),
                        ],
                        'date_added',
                        [
                            'attribute' => 'discontinued',
                            'label'=>'Актуальность',
                            'format'=>'raw',
                            'value'=> call_user_func(function($data){
                                if($data->discontinued == '0'){ //not active
                                   return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Закрыта</span>';
                                }elseif($data->discontinued == '1'){//active
                                   return '<span class="glyphicon glyphicon-ok" style="color: green"> Активна</span>';
                                } 
                            }, $model),
                        ],
                    ],
                ]) ?>
            </div>
          </div> 
        </div>
    </div>
    
    
   
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-hdd"></i> Перечень электронных компонентов в спецификации</h4>
          
        </div>
        
        <div class="panel-body">
           <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $model,
                'formId' => 'dynamic-form',
                'formFields' => [
                    /*'full_name',
                    'address_line1',
                    'address_line2',
                    'city',
                    'state',
                    'postal_code',*/
                    'idelement',
                    'status'
                ],
            ]); ?>
            
            
            <div class="row">
                <div class="search-form">
                    <div class="box box-solid bg-gray-light" style="border: 1px solid #d2d6de;">
                        <div class="box-body">
                            <span>Поиск для добавления в перечень:</span>
                                <?php echo $this->render('_searchelem', ['searchModelelem' => $searchModelelem]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
            
            <div class="container-items"><!-- widgetContainer -->
               
                    <?= Tabs::widget([
                        'options' => [
                            'class' => 'nav-tabs',
                            'style' => 'margin-bottom: 15px',
                        ],
                            'items' => [
                                    
                                  /*      [
                                            'label' => 'Specification',
                                            'content' => $this->render('specification', ['dataProviderspec' => $dataProviderspec, 'searchModelspec' => $searchModelspec]),
                                             'active' => true,
                                        ],*/

                                [
                                            'label' => 'Template of the specification',
                                            'content' => $this->render('specificationtemplate', ['dataProviderspectemp' => $dataProviderspectemp, 'searchModelspectemp' => $searchModelspectemp]),
                                        ],
                                [
                                    'label' => 'Out of stock',
                                    'content' => $this->render('outof', ['model' => $modelOut, 'dataProvideroutof' => $dataProvideroutof]),
                                ],
                                [
                                    'label' => 'Requests',
                                    'content' => $this->render('requests', ['searchModelrequest' => $searchModelrequest, 'dataProviderreq' => $dataProviderreq]),
                                ],
                                [
                                    'label' => 'Shortage',
                                    'content' => $this->render('shortage', ['dataProvidersh' => $dataProvidersh, 'searchModelsh' => $searchModelsh]),
                                ],
                            ]]);
                    ?>
                    <?php // Html::a('Недостачи', ['shortage', 'idboard' => $model->idboards], ['class' => 'btn btn-primary']) ?>
            </div>  
             
                <div class="item panel panel-default"><!-- widgetBody -->
                           <div class="panel-heading">
                               
                          
                               <div class="pull-right">
                                  <!-- <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus" title="Создать шаблон для спецификации"></i></button>-->
                                 <span><?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['specificationtemplate/create'], [ 'title'=>'Создать единицу товара', 'class' => 'btn btn-success']) ?></span>
                                   <span><?= Html::a('<i class="glyphicon glyphicon-eye-open"></i> template', ['create'], [ 'title'=>'Создать единицу товара', 'class' => 'btn btn-warning']) ?></span>
                               </div>
                               <div class="clearfix"></div>
                           </div>
                           <div class="panel-body">

                              <?php Pjax::begin(['id' => 'specifications']); ?>  
                                <?= GridView::widget([
                                        'dataProvider' => $dataProviderspec,
                                        'filterModel' => $searchModelspec,
                                   
                                        'tableOptions' => [
                                            'class' => 'table table-striped table-bordered'
                                        ],
                                       /* 'rowOptions' => function($modelspec, $key, $index, $grid){
                                            if($modelspec->status == '0'){  // not active
                                                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
                                            }elseif($modelspec->status == '1'){  //active
                                                return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
                                            }elseif($modelspec->status == '2'){ //cancel
                                                return ['style' => 'label label-default glyphicon glyphicon-time; color: #b2b2b2;']; //cancel f97704 - orange color:#c48044
                                            }
                                        },*/
                                        'columns' => [
                                            [
                                                'attribute' => 'idelement',
                                                'contentOptions'=>['style'=>'width: 90px;'],
                                            ],
                                            [
                                                'attribute' => 'idelement',
                                                'label' => 'Наименование',
                                                'format' => 'raw',
                                                'value' => function($data){
                                                       return html::a($data->elements->name, ['elements/view', 'id' => $data->idelement]);
                                                }
                                                
                                            ],
                                            [
                                                'attribute' => 'idelement',
                                                 'label' => 'Номинал',
                                                'value' => 'elements.nominal'
                                            ],
                                            [
                                                'attribute' => 'quantity',
                                                'format' => 'raw',
                                                'value' => function($data){
                                                    return '<strong><center>' . $data->quantity . '</center></strong>';
                                                },
                                                'contentOptions'=>['style'=>'width: 70px;'],
                                            ],
                                            [
                                               'attribute' => 'idprice',
                                               'label' => 'Цена',
                                               'value' => function($data){
                                                return empty($data->idprice) ? '-' : $data->prices->price;
                                                   //eturn $data->prices->unitPrice;
                                               }

                                            ],
                                            'ref_of',
                                            [
                                                'attribute' => 'status',
                                                'format' => 'raw',
                                                'value'=> call_user_func(function($data){
                                                    if($data->status == '0'){ //not active
                                                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> недостач нет</span>';
                                                    }elseif($data->status == '1'){//active
                                                       return '<span class="glyphicon glyphicon-ok" style="color: green"> Имеется недостача</span>';
                                                    } elseif($data->status == '2'){//cancel
                                                       return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"> Отменено в недостачах</span>';
                                                    }

                                                }, $modelspec),
                                                'filter' => ['0'=> 'недостач нет', '1' => 'недостача','2' => ' Отменено в недостачах']
                                            ],

                                            ['class' => 'yii\grid\ActionColumn',
                                             //'controller' => common\models\Outofstock   
                                                ],
                                        ],
                                    ]); ?>
                              <!-- .row -->
                            <?php Pjax::end(); ?>  
                           </div>
                </div>
     
            </div>
            <?php DynamicFormWidget::end(); ?>

   
    </div>
</div>

