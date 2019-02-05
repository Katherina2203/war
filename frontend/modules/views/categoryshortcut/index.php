<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;

use common\models\Categoryshortcut;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryshortcutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Category shortcuts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoryshortcut-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box box-solid">
        <div class="box">
            <div class="box-header with-border">
                <h3>Список выполнения </h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                
                    <?php
                     $dataParentProvider = new ActiveDataProvider([
                           'query'=> Categoryshortcut::find()->where(['parent_id' => FALSE])->orderBy('id DESC')
                        ]);
                       foreach ($dataParentProvider->models as $model) {
                           echo '<div class="box-header with-border"><strong class="category-link">' . $model->name . '</strong></div>';
                           echo '<ul>';
                                foreach ($dataProvider->models as $model) {
                                    echo '<li><a class="category-child-link" href="'. 'categoryshortcut/viewbycategory/'.$model->parent_id .'">'.$model->name.'</a></li>';
                                }
                           echo '</ul>';
                       }
                    ?>  
                </div>
            </div>
        </div>
    </div>

    
    <script>
          $this->registerJs('
                jQuery(document).pjax(".category-link", "#item_list", {
                    "push": true,
                   "replace": false,
                    "timeout": 1000,
                    "scrollTo": false
                });
                ');
    </script>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // 'id',
            [
                'attribute' => 'parent_id',
                'label' => 'category',
                'value' => function($model){
                    return $model->parent_id == FALSE ?  $model->name : '-';
                }
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model, $key){
                    return $model->parent_id == FALSE ? '-' : Html::a($model->name, ['viewbycategory', 'id' => $key]);
                }
            ],

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
