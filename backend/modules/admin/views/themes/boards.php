<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <p>
        <?= Html::a('Create Boards', ['boards/create'], ['class' => 'btn btn-success']) ?>
    </p>

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
           // ['class' => 'yii\grid\SerialColumn'],

            'idboards',
           // 'idtheme',
           // 'idthemeunit',
            
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(Html::encode($data->name), Url::to(['viewitems', 'id' => $data->idboards]));
                }
            ],
           [
               'attribute' => 'current',
               'value' => function($model){
                if($model->current !=null){
                    return ArrayHelper::getValue($model, 'users.surname');
                }else{
                    return '-';
                }
               },
               'filter' => Html::activeDropDownList($searchModel, 'current', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите ответственного']),
           ],
            
            'date_added',
            [
                'attribute' => 'discontinued',
               // 'format' => 'boolean',
                'filter' => ['1'=> 'yes active', '0'=> 'no close'],
                'value' => function($data){
                      if($data->discontinued == 1){
                          return 'Актуально';
                      }elseif($data->discontinued == 0){
                          return 'Закрыта';
                      }

                  },
                'filter'=>['1' => 'Актуально', '2' => 'Закрыта'],
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
            ],
            

            ['class' => 'yii\grid\ActionColumn',
             'controller' => 'boards'
            ],
        ],
    ]); ?>
   
</div>
