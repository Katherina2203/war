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
        'rowOptions' => function($model, $key, $index, $grid){
            if($model->discontinued == '1'){
                return ['class' => 'info'];
            }else{
                 return ['class' => 'danger'];
            }
           
        },
       // 'showPageSummary'=>true,
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
      //  'panel'=>['type'=>'primary', 'heading'=>'Список плат'],
        'columns' => [
          //  ['class'=>'kartik\grid\SerialColumn'],
            [
                'attribute' => 'idboards',
                'label' => '№ платы',
            ],
            
            [
                'attribute' => 'idtheme',
                'label' => 'Проект',
                'value' => 'themes.name',
            /*    'value'=>function ($model, $key, $index, $widget) { 
                     return $model->themes->name;
                },*/
                'format' => 'text',
             //   'filterType'=>GridView::FILTER_SELECT2,
             //   'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->indexBy('idtheme')->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
                'filter'=>ArrayHelper::map(Themes::find()->where(['status' => 'active'])->orderBy('name')->asArray()->all(), 'idtheme', 'name'), 
            /*    'filterWidgetOptions'=>[
                     'pluginOptions'=>['allowClear'=>true],
                    ],*/
           //     'filterInputOptions'=>['placeholder'=>'Any theme'],
                'group'=>true,  // enable grouping
            ],
            [
                'attribute' => 'idthemeunit',
                'label' => 'Модуль',
                'value' => function($model){
                    return empty($model->idthemeunit) ? '-' : $model->themeunits->nameunit;
                },
                //'value' => 'themeunits.nameunit',
                'format' => 'raw',
               // 'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->indexBy('idunit')->all(), 'idunit', 'nameunit'),['class'=>'form-control','prompt' => 'Выберите модуль']),
             //   'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(Themeunits::find()->orderBy('nameunit')->asArray()->all(), 'idunit', 'nameunit'), 
             /*   'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],*/
             //   'filterInputOptions'=>['placeholder'=>'Any themeunit'],
                'group'=>true,  // enable grouping
                'subGroupOf'=>1 // supplier column index is the parent group
            ],
            [
                'attribute' => 'name',
                'label' => 'Название платы',
          //      'pageSummary'=>'Page Summary',
           //     'pageSummaryOptions'=>['class'=>'text-right text-warning'],
                'format' => 'raw',
                'value' => function($model, $key, $index){
                   return Html::a($model->name, ['view', 'id' => $model->idboards]);
                },
            ],
            [
                'attribute' => 'current',
                'label' => 'Ответственный',
             /*   'value' => function($model){
                    return $model->users->surname;
                 //   return empty($model->current) ? '-' : $model->users->surname;
                },*/
                'value' => 'users.surname',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'current', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите ответственного']),
            ],
            
            'date_added',
            
           

            ['class' => 'yii\grid\ActionColumn',
             'contentOptions' => ['style' => 'width:45px;'],
             'template' => '{view} {update} {delete} {quicklist} ',  
             'buttons' => [
                  'quicklist' => function ($url,$model,$key) {
                  $url = Url::to(['quicklist', 'iduser' => yii::$app->user->identity->id, 'idboards' => $key, 'idtheme' => $model->idtheme, 'idthemeunit' => $model->idthemeunit]);
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,
                            ['title' => 'Быстро скопмлектовать']
                            );
                },
             ],
                ],
        ],
    ]); ?>
</div>
