<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Specification');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specification-index">
<h2>Template of the specification</h2>
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
<?php Pjax::begin(); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProviderspec,
        'filterModel' => $searchModelspec,
        'columns' => [
            'idspec',
            'quantity',
            'idelement',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
