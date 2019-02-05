<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Boards', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModelboards,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idboards',
            'idtheme',
            'idthemeunit',
            'name',
            'current',
            'date_added',
            'discontinued',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
