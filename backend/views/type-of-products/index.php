<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TypeOfProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы категорий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-of-products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать тип', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'idtype',
            'idcategory',
            'name',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
