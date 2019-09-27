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
<div class="specificationtemplate-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Source Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idspt',
            'quantity',
            'idelement',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>
        <?php Pjax::end(); ?>
</div>
