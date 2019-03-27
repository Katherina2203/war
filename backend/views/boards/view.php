<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Boards */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-view">
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <span>Номер платы: <strong><?= $model->idtheme. '-'. $model->idthemeunit. '-'. $model->idboards;?></strong></span>
               <h4><i class="glyphicon glyphicon-hdd"></i> <?= Html::encode($this->title) ?></h4>
            </div>
            <div class="col-xs-6">
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->idboards], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->idboards], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
             
                </p>
                 <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                   'idboards',
                 /*   [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => '<strong>'.$model->name.'</strong>', 
                    ],*/
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
                    'discontinued',
                ],
            ]) ?>
            </div>
        </div>
    </section>
    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-hdd"></i> Перечень электронных компонентов</h4></div>
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
                    'full_name',
                    'address_line1',
                    'address_line2',
                    'city',
                    'state',
                    'postal_code',
                ],
            ]); ?>
            
            
            <div class="row">
                <div class="search-form">
                    <div class="box box-solid bg-gray-light" style="border: 1px solid #d2d6de;">
                        <div class="box-body">
                            <span>Поиск для добавления в перечень:</span>
                            <?php  echo $this->render('_searchelem', ['model' => $searchModelelem]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="container-items">
            
            <div class="container-items"><!-- widgetContainer -->
                <div>
                    <?= Html::a('Недостачи', ['shortage', 'idboard' => $model->idboards], ['class' => 'btn btn-primary']) ?>
                </div>
                       <div class="item panel panel-default"><!-- widgetBody -->
                           <div class="panel-heading">
                               
                               <h3 class="panel-title pull-left">Elements</h3>
                               <div class="pull-right">
                                   <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                   <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                               </div>
                               <div class="clearfix"></div>
                           </div>
                           <div class="panel-body">
                            <div>
                                
                            </div>
                               <div class="row">
                                <?= GridView::widget([
                                        'dataProvider' => $dataProvideroutof,
                                        'filterModel' => $searchModeloutof,
                                        'columns' => [
                                            'idofstock',
                                            'idelement',
                                            [
                                                'attribute' => 'idelement',
                                                'label' => 'Наименование',
                                                'value' => 'elements.name'
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
                                                }
                                            ],
                                            [
                                                'attribute' => 'iduser',
                                                'value' => 'users.surname',
                                               //   'filter' => Html::activeDropDownList($searchModeloutof, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Select user']),
                                            ],
                                           
                                            'date',
                                         //   'idtheme',
                                            [
                                               'attribute' => 'idprice',
                                               'label' => 'Цена',
                                               'value' => function($data){
                                                return empty($data->idprice) ? '-' : $data->prices->price;
                                                   //eturn $data->prices->unitPrice;
                                               }

                                            ],
                                            [
                                                'attribute' => 'idprice',
                                                'label' => 'USD',
                                                'value' => function($data){
                                                    return empty($data->idprice) ? '-' : $data->prices->usd;
                                                }
                                            ],
                                            [
                                                'label' => 'Сумма',
                                             //   'attribute' => 'amount',
                                             //   'footer' => backend\components\TotalPrice::pageTotal($dataProvider->models,'amount'),
                                               
                                            ],
                                            'ref_of_board',

                                            ['class' => 'yii\grid\ActionColumn',
                                             //'controller' => common\models\Outofstock   
                                                ],
                                        ],
                                    ]); ?>
                               </div><!-- .row -->

                           </div>
                       </div>

            </div>
            <?php DynamicFormWidget::end(); ?>


        </div>
    </div>
    
    
   
</div>

</div>

