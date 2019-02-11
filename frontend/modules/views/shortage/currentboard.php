<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShortageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shortages by current board';
$this->params['breadcrumbs'][] = ['label' => 'Недостачи по текущей плате', 'url' => ['boards/currentboards']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="shortage-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shortage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
          //  'idboard',
            
            [
                'attribute' => 'idelement', 
                'label' => 'name',
                'value' => function($model){
                    return $model->elements->name;
                }
            ],
            [
                'attribute' => 'idelement', 
                'label' => 'nominal',
                'value' => function($model){
                    return ;
                }
            ],
            'ref_of',
            'quantity',
            // 'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
