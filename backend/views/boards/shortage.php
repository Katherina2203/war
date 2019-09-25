<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShortageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shortages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-shortage">
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
        <li role="presentation"><a href="<?= Url::to(['boards/view', 'id' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= 'Out of stock' ?></a></li>
        <li role="presentation" ><a href="<?= Url::to(['boards/requests', 'idb' => $model->idboards]) ?>"><span class="glyphicon glyphicon-comment"></span> <?=  'Requests'?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['boards/shortage', 'idboard' => $model->idboards]) ?>"><span class="glyphicon glyphicon-comment"></span> <?=  'Shortage'?></a></li>
    </ul>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shortage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvidersh,
      //  'filterModel' => $searchModelsh,
        'columns' => [
            'id',
            /*[
                'attribute' => 'idboard',
                'label' => 'PCB',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->boards->name, ['boards/view', 'idboards'=> $model->idboard]). ',<br/> ' .
                            $model->boards->themes->name;
                }
            ],*/
            
             [
                'attribute' => 'idelement', 
                'label' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->elements->name, ['elements/view', 'id' => $model->idelement]) . ', <br/>' . $model->elements->nominal;
                }
            ],
            [
                'attribute' => 'idelement', 
                'label' => 'nominal',
                'value' => function($model){
                    return $model->elements->nominal;
                }
                
            ],
            'ref_of',
                    
            'quantity',
            
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data){
                    if($data->status == '1'){
                        return '<span class="label label-success">Active</span>';
                    }elseif($data->status == '4'){
                        return '<span class="label label-default">Close</span>';
                    }
                   
                },
                'filter'=>['1' => 'Active', '2' => 'Close'],
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
            ],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
