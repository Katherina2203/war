<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idcategory_type',
            'idtype_of_products',
            'idcategory',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
