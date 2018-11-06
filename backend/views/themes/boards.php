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
<div class="themes-boards">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-8">
                        <span><?= yii::t('app', 'Project theme:')?><p>idtheme: <?= $model->idtheme?></p>
                        <h2 class="box-title"><?= $model->themes->name?></h2></span>
                        <span><?= yii::t('app', 'Unit name:')?><p>idunit: <?= $model->idthemeunit?></p><h3 class="box-title"><?= $model->themeunits->nameunit?></h3></span>
                    </div>
                    
                        
                </div>   
            </div>  
        </div>  
    </div>  
    <p>
        <?= Html::a('Create Board', ['createboard', 'idtheme' => $model->idtheme, 'idthemeunit' => $model->idthemeunit], ['class' => 'btn btn-success']) ?>
    </p>

    <?= 
            GridView::widget([
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
                    return Html::a(Html::encode($data->name), Url::to(['boards/view', 'id' => $data->idboards]));
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
