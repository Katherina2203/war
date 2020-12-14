<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Themes;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Текущие проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="<?= Url::to(['index']) ?>"><?= 'Current projects' ?></a></li>
        <li role="presentation"><a href="<?php echo Url::to(['themes/index', 'iduser' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-user"></span> <?=  'All Projects' ?></a></li>
       <!-- <li role="presentation"><a href="<?= Url::to(['elements/view', 'id' => yii::$app->user->identity->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= 'Member View' ?></a></li>
        <li role="presentation" ><a href="#"><span class="glyphicon glyphicon-comment"></span> <?=  'Posts created by {name}'?></a></li>
    -->  
    </ul>
    <div class="box box-solid bg-gray-light" style="background: #fff;">
        <div class="box-body">
   <?php Pjax::begin(['id' => 'themes-indexshort']); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'pjax' => true,
         'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'projectnumber',
                'contentOptions' => ['style' => 'max-width: 60px;white-space: normal'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Themes $model) {
                      return Html::a(Html::encode($model->name), Url::to(['units', 'id' => $model->idtheme]));
                },
                'format' => 'raw',
            ],
            'customer', 
            'quantity',
            'subcontractor',
         /*   [
                'attribute' => 'units_count',
                'label' => 'Количество модулей',
                'format' => 'raw',
                'value' => function($data){
                    return $data->units_count;
                  //  return Html::a(Html::encode($data->units_count), Url::to(['units', 'id' => $data->idtheme]), ['title' => 'Список моделуй в проекте']);
                }
            ],*/
          //  ['class' => 'yii\grid\ActionColumn'],
             
        
        ],
    ]); ?>
   <?php Pjax::end(); ?>  
        </div>
    </div>
</div>
