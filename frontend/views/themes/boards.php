<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->discontinued == '1'){  // not active
              //  return ['style' => 'color: #b2b2b2;'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->discontinued == '0'){  //active
                 return ['style' => 'color: #b2b2b2;']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }
        },
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'resizableColumns'=>true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'idboards',
           // 'idtheme',
           // 'idthemeunit',
            
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(Html::encode($data->name), Url::to(['viewitems', 'id' => $data->idboards]));
                }
            ],
            'current',
            'date_added',
            [
                'attribute' => 'discontinued',
                'label' => 'Active',
            ],   

            
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
