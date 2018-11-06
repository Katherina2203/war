<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Category;
$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
 <div class="page-title">
        <div class="title_left">
            <h3>
                <?= $this->title ?>
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
            <span><?php // $this->render('_search', ['model' => $searchModel]); ?></span>
        </div>
    </div>
    
   <div class="clearfix"></div>
     
     
    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'parent',
               /* 'value' => function ($model) {
                    return empty($model->parent_id) ? '-' : $model->parent->name;
                },*/
                
                'value' => function($model){
                    return $model->parent ==0 ?  $model->name_ru : '-';
                }
            ],
            [
                'attribute' => 'name_ru',
                'label' => 'Подкатегория',
                'format' => 'raw',
                'value' => function(Category $data){
                    return Html::a(Html::encode($data->name_ru. ' (' . $data->elements_count . ')'), Url::to(['items', 'id' => $data->idcategory]));
                }
                
            ],
                    'elements_count',
         /*   [
                'attribute' => 'elements_count',
                'label' => 'Elements'
            ],*/

         //   ['class' => 'yii\grid\ActionColumn'],
                    
                    [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create} {view} {update} {delete}',
                'buttons' => [
                    'create' => function ($url, $model, $key) {
                         return Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', $url);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
