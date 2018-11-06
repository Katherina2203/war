<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemeunitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Themeunits;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => yii::t('app', 'Current projects'), 'url' => ['indexshort']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themeunits-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-default">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-header with-border"><h3 class="box-title">Модули проекта</h3></div>
                <div class="box-body">
                    <p>
                        <?= Html::a('Создать модуль', ['themeunits/createbytheme', 'idtheme' => $model->idtheme], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' =>  $searchModelUnits,
                        'bordered' => true,
                        'striped' => false,
                        'condensed' => false,
                        'responsive' => true,
                        'hover' => true,
                        'columns' => [
                            'idunit',
                            [
                                'attribute' => 'nameunit',
                                'format' => 'raw',
                                'value' => function(Themeunits $data){
                                    return Html::a(Html::encode($data->nameunit) . '<span> ('. $data->quantity_required . ') </span>', Url::to(['themes/boards', 'idtheme' => $data->idtheme, 'idthemeunit' => $data->idunit]),['title' => 'Список модулей в проекте']);
                                }
                            ],
                            'created_at',
                            [
                                'attribute' => 'boards.count',
                                'label' => 'boards',
                                'format' => 'raw',
                                'value' => function($data){
                                      return Html::a(Html::encode($data->quantity_required), Url::to(['boards', 'idtheme' => $data->idtheme, 'idthemeunit' => $data->idunit]), ['title' => 'Список плат в модуле']);
                                }
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                             'controller' => 'themeunits'
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-default">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="box-header with-border"><h3 class="box-title">Заявки проекта</h3></div>
                <div class="box-body">
                   <p>
                        <?php echo Html::a('Создать заявку', ['requests/createintheme', 'iduser' => yii::$app->user->identity->id, 'idproject' => $model->idtheme], ['class' => 'btn btn-success']) ?>
                    </p>
                    <div class="search-form">
                        <?php $form = ActiveForm::begin([
                        'action' => ['requests/index'],
                        'method' => 'get',
                            ]); ?>
                           <?php $searchRequest = new backend\models\RequestsSearch();
                           echo $form->field($searchRequest, 'name', [
                               'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                                   Html::submitButton('Search', ['class' => 'btn btn-default']) .
                                   '</span></div>',
                               ])->textInput(['placeholder' => 'Search in requests by name']);
                               ?>
                      <?php ActiveForm::end(); ?>
                    </div>
                    
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="<?= Url::to(['themes/units']) ?>"><span class="glyphicon glyphicon-unchecked"></span> <?=  'Не обработанные'?></a></li>
                        <li role="presentation" ><a href="<?= Url::to(['themes/units', ]) ?>"><span class="glyphicon glyphicon-ok"></span> <?=  'Активны'?></a></li>
                        <li role="presentation" ><a href="<?= Url::to(['themes/units', 'id' => $modelreq->idrequest]) ?>"><span class="glyphicon glyphicon-remove"></span> <?=  'Отмена'?></a></li>
                        <li role="presentation" ><a href="<?= Url::to(['themes/units', 'id' => $modelreq->idrequest]) ?>"><span class="glyphicon glyphicon-saved"></span> <?=  'Выполнено'?></a></li>
                    </ul>
            
                   
                    <?= GridView::widget([
                            'dataProvider' => $dataProviderreq,
                            'filterModel' => $searchModelreq,
                            'hover' => true,
                            'tableOptions' => [
                                    'class' => 'table table-responsive table-hover'
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'columns' => [
                                'idrequest',
                             [
                                    'attribute' => 'name',
                                    'format'=>'raw',
                                    'value' => function ($modelreq, $key, $index) { 
                                          return Html::a($modelreq->name . '<p>Created: '. $modelreq->created_at .'</p>', ['requests/view', 'id' => $modelreq->idrequest]);
                                    },
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
                                    }
                                ],
                                [
                                    'attribute' => 'iduser',
                                    'label' => 'Кто заказывал',
                                   
                                ],
                                [
                                    'attribute' => 'required_date',
                                    'format' => ['date', 'php:Y-m-d']
                                ],
                                'note',
                                ['class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['style' => 'width:45px;'],
                                    'controller' => 'requests',
                                    'template' => '{view}', 
              
                                ],
                             ]
                        ]); ?>
                     
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-default">
                <div class="box-header with-border"><h3 class="box-title">Стоимость проекта</h3></div>
            </div>
        </div>
    </div>
</div>
