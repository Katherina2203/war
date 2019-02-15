<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use common\models\Themeunits;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemeunitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Themeunits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themeunits-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Themeunits', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'idunit',
           
            [
                'attribute' =>  'idtheme',
                'value' => 'themes.name'
            ],
            [
                'attribute' => 'nameunit',
                'format' => 'raw',
                'value' => function(Themeunits $data){
                    return Html::a(Html::encode($data->nameunit), Url::to(['boards', 'idthemeunit' => $data->idunit]));
                } /*. '('.$data->boards_count. ')' */
            ],
            'quantity_required',
            'status',
            'created_at',
            [
                'attribute' => 'boards_count',
                'label' => 'Boards'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
