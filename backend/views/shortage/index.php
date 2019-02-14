<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShortageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shortages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortage-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shortage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id' => 'shortage']); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
       // 'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns'=>true,
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->status == '4'){  // not active
                return ['style' => 'label label-default glyphicon glyphicon-time; color: #b2b2b2;'];;  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->status == '1'){  //active
               //  return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            return ;

            }
        },
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'idboard',
                'label' => 'PCB',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->boards->name, ['boards/view', 'idboards'=> $model->idboard]). ',<br/> ' .
                            $model->boards->themes->name;
                }
            ],
            
             [
                'attribute' => 'idelement', 
                'label' => 'name',
                'value' => function($model){
                    return $model->elements->name;
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
