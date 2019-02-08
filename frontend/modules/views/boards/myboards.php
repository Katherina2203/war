<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список моих плат';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
  <?php Pjax::begin(['id' => 'myboards']); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
      /*  'rowOptions' => function($model, $key, $index, $grid){
            if($model->discontinued == '1'){
                return ['class' => 'info'];
            }else{
                 return ['class' => 'danger'];
            }
           
        },*/
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

           
            [
                'attribute' => 'idboards',
                'label' => 'Номер платы',
               // 'inputWidth'=>'40%'
            ],
            [
                'attribute' => 'name',
                'label' => 'Название платы',
             //   'pageSummary'=>'Page Summary',
              //  'pageSummaryOptions'=>['class'=>'text-right text-warning'],
                'format' => 'raw',
                'value' => function($model, $key, $index){
                   return Html::a($model->name, ['view', 'id' => $model->idboards]). '<br/><span style="color:grey"> Created: <small>'. $model->date_added . '</small></span>';
                },
            ],
            [
                'attribute' => 'idtheme',
                'value' => function($model){
                    return Html::a($model->themes->name, ['view', 'id' => $model->idboards]);
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
            ],
            [
                'attribute' => 'idthemeunit',
                'value' => function($model){
                    return Html::a($model->themeunits->nameunit, ['view', 'id' => $model->idboards]);
                },
                'format' => 'raw',
                //'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
            [
                'attribute' => 'idboards',
                'label' => 'Недостачи',
                'value' => function($model){
                    return Html::a(('<span class="label label-warning">' . $model->shortage->idboard . '</span>'), ['shortage/currentboard', 'idboard' => $model->idboards]);
                },
                'format' => 'raw',
            ],           
            [
                'attribute' => 'discontinued',
                'format' => 'raw',
                'value' => function($data){
                    if($data->discontinued == 1){
                        return '<span class="label label-success">Актуально</span>';
                    }elseif($data->discontinued == 0){
                        return '<span class="label label-danger">Закрыто</span>';
                    }
                },
                'filter'=>['1' => 'Актуально', '0' => 'Закрыто'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:45px;'],
                'template' => '{view} {changestatus}',  
              /*  'buttons' => [
                    'changestatus' => function ($url,$model,$key) {
                        $url = Url::to(['viewprocess', 'idrequest' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', $url,
                            ['title' => 'Посмотреть обработку заявок']
                            );
                },
              ],*/
           
                ],
        ],
    ]); ?>
      <?php Pjax::end(); ?>  
</div>
