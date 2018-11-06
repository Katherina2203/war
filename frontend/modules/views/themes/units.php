<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemeunitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Themeunits;


$this->title = 'Модули';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themeunits-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать модуль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' =>  $searchModelUnits,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idunit',
          //  'idtheme',
            
            [
                'attribute' => 'nameunit',
                'format' => 'raw',
                'value' => function(Themeunits $data){
                    return Html::a(Html::encode($data->nameunit), Url::to(['boards', 'id' => $data->idtheme]),['title' => 'Список позиций в счете']);
                }
            ],
            'quantity_required',
            'date_update',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
