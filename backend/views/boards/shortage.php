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
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shortage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvidersh,
        'filterModel' => $searchModelsh,
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
