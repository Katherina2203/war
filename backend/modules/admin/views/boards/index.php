<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Themes;
use common\models\Themeunits;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список плат';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-index">

    
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <p>
        <?= Html::a('Создать плату', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
      //  'floatHeader' => true,
        'panel'=>['type'=>'primary', 'heading'=>'Список плат'],
        'columns' => [
           // ['class'=>'kartik\grid\SerialColumn'],
            [
                'attribute' => 'idboards',
                'label' => '№ платы',
            ],
            [
                'attribute'=>'idtheme',
                'label' => 'Проект',
                'width'=>'310px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return $model->themes->name;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(Themes::find()->orderBy('name')->asArray()->all(), 'idtheme', 'name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Any theme'],
                'group'=>true,  // enable grouping
            ],
            [
                'attribute'=>'idthemeunit', 
                'label' => 'Модуль',
                'width'=>'250px',
                'value' => 'themeunits.nameunit',
                /*'value'=>function ($model, $key, $index, $widget) { 
                //    return $model->themeunits->nameunit;
                },*/
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(Themeunits::find()->orderBy('nameunit')->asArray()->all(), 'idunit', 'nameunit'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Any themeunit']
            ],
           
            [
                'attribute' => 'name',
                'label' => 'Название платы',
                'format' => 'raw',
                'value' => function($model, $key, $index){
                   return Html::a($model->name, ['view', 'id' => $model->idboards]);
                },
                'pageSummary'=>'Page Summary',
                'pageSummaryOptions'=>['class'=>'text-right text-warning'],
            ],
            [
                'attribute' => 'current',
                'label' => 'Ответственный',
                'value' => 'users.surname',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'current', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите ответственного']),
            ],
            
            'date_added',
            
            [
                'attribute' => 'discontinued',
                'filter' => [0=> 'Закрыто', 1 => 'Активна']
            ],

            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {quicklist} ',  
             'buttons' => [
                  'quicklist' => function ($url,$model,$key) {
                  $url = Url::to(['quicklist', 'idboards' => $key, 'idtheme' => $model->idtheme, 'idthemeunit' => $model->idthemeunit]);
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,
                            ['title' => 'Быстро скопмлектовать']
                            );
                },
             ],
                ],
        ],
    ]); ?>
</div>
