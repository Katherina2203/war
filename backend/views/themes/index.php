<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
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
        <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
         //   ['class' => 'yii\grid\SerialColumn'],

            'idtheme',
            'projectnumber',
            [
                'attribute' => 'name',
                'format'=>'raw',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idtheme]);
                },
            ],
         //   'full_name',
            'customer',
           // 'description:ntext',
           // 'subcontractor',
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
