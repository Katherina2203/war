<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectshortcutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категория';//Yii::t('app', 'Projectshortcuts');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="invoice">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="col-xs-12">
            <?= DetailView::widget([
                'model' => $modelcategory,
                'attributes' => [
                    
                    
                    [
                        'attribute' => 'parent_id',
                        'label' => 'Родительская',
                        'value' => function($model){
                            return $model->parent_id == FALSE ?  $model->name : '-';
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'Подкатегория',
                    ],
                    
                ],
            ]) ?>
        </div>
    </div>
<div class="projectshortcut-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idshortcut',
            'description',
            'significance',

        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
</section>
