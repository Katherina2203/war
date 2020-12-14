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

    <h1><?= Html::encode($this->title) ?></h1>
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
            [
                'attribute' => 'discontinued',
                'label' => 'Активность',
            ],
           

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
