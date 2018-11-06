<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Category;
$this->title = yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
        <span><?php // $this->render('_search', ['model' => $searchModel]); ?></span>
    
        <?php
            foreach ($dataProviderParent->models as  $id =>$model) {
                            $dataProviderChild = new ActiveDataProvider([
                                 'query'=> Category::find()->where("parent=:parent", [":parent"=>$model->idcategory]) //, [":parent"=>$model->idcategory = 1]
                            ]); 
                           echo '<div class="box-header with-border"><strong class="category-link">' . $model->name . '</strong></div>';
                           echo '<ul>';
                                foreach ($dataProviderChild->models as $child) {
                                echo "<li>";
                                echo   Html::a(Html::encode($child->name_ru), Url::to(['items', 'id' => $child->idcategory]));
                                echo "</li>";
                                }
                           echo '</ul>';
                       }
        ?>  
  
    
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
              //      'elements_count',
         /*   [
                'attribute' => 'elements_count',
                'label' => 'Elements'
            ],*/

         //   ['class' => 'yii\grid\ActionColumn'],
                    
              /*      [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create} {view} {update} {delete}',
                'buttons' => [
                    'create' => function ($url, $model, $key) {
                         return Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', $url);
                    }
                ],
            ],*/
        ],
    ]); ?>
</div>
