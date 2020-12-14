<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="<?= Url::to(['themes/indexshort']) ?>"><?= 'Current Projects' ?></a></li>
        <li role="presentation"  class="active"><a href="<?php echo Url::to(['themes/index', 'iduser' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-user"></span> <?=  'All Projects' ?></a></li>
       <!-- <li role="presentation"><a href="<?= Url::to(['elements/view', 'id' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= 'Member View' ?></a></li>
        <li role="presentation" ><a href="#"><span class="glyphicon glyphicon-comment"></span> <?=  'Posts created by {name}'?></a></li>
    -->  
    </ul>
    <div class="box box-solid bg-gray-light" style="background: #fff;">
        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->status == 'active'){  // not active
              //  return ['style' => 'color: #b2b2b2;'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->status == 'close'){  //active
                 return ['style' => 'color: #b2b2b2;']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
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
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'idtheme',
            'projectnumber',
            [
                'attribute' => 'name',
                'format'=>'raw',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idtheme]);
                },
            ],
          //  'full_name',
            'customer',
          //  'description:ntext',
          //  'subcontractor',
            'quantity',
            'date',
            [
                'attribute' => 'status',
                'filter' => ['active' => 'актуально', 'close' => 'закрыто'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
   </div>
