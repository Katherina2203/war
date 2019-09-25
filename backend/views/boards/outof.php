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
use wbraganca\dynamicform\DynamicFormWidget;

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
   <div class="row">
         <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><span>Номер платы: <strong><?= $model->idtheme. '-'. $model->idthemeunit. '-'. $model->idboards;?></strong></span>
                    <h4><i class="glyphicon glyphicon-hdd"></i> <?= Html::encode($this->title) ?></h4>
                </div>
            <div class="box-body">
            
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
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="<?= Url::to(['boards/view', 'id'=> $model->idboards]) ?>"><?= 'Specification' ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['boards/template', 'idb' => $model->idboards]) ?>"><span class="glyphicon glyphicon-user"></span> <?=  'Template of the specification' ?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['boards/outof', 'idboard' => $model->idboards]) ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= 'Out of stock' ?></a></li>
        <li role="presentation" ><a href="<?= Url::to(['boards/requests', 'idb' => $model->idboards]) ?>"><span class="glyphicon glyphicon-comment"></span> <?=  'Requests'?></a></li>
        <li role="presentation" ><a href="<?= Url::to(['boards/shortage', 'idboard' => $model->idboards]) ?>"><span class="glyphicon glyphicon-comment"></span> <?=  'Shortage'?></a></li>
    </ul>
 


      
    
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
                                                'label' => 'User',
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
