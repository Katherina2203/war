<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список плат';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

   
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->discontinued == '1'){
                return ['class' => 'info'];
            }else{
                 return ['class' => 'danger'];
            }
           
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            [
                'attribute' => 'idboards',
               // 'inputWidth'=>'40%'
            ],
            
            [
                'attribute' => 'idtheme',
                'value' => 'themes.name',
                'format' => 'text',
                 'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
            'idthemeunit',
           [
                'attribute' => 'name',
                'label' => 'Название платы',
             //   'pageSummary'=>'Page Summary',
              //  'pageSummaryOptions'=>['class'=>'text-right text-warning'],
                'format' => 'raw',
                'value' => function($model, $key, $index){
                   return Html::a($model->name, ['view', 'id' => $model->idboards]);
                },
            ],
            'current',
            'date_added',
            'discontinued',

            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {quicklist} ',  
             'buttons' => [
                  'quicklist' => function ($url,$model,$key) {
                  $url = Url::to(['quicklist', 'idboards' => $key, 'idtheme' => $model->idtheme, 'idthemeunit' => $model->idthemeunit]);
                    return Html::a('<span class="glyphicon glyphicon-plus">Создать перечень</span>', $url,
                            ['title' => 'Быстро скопмлектовать']
                            );
                },
             ],
                ],
        ],
    ]); ?>
</div>
