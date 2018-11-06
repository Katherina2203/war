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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать модуль', ['themeunits/createbytheme', 'idtheme' => $model->idtheme], ['class' => 'btn btn-success']) ?>
    </p>
    
    
    <div>
        
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' =>  $searchModelUnits,
        
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

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
            [
                'attribute' => 'boards.count',
                'label' => 'boards',
                'format' => 'text',
                'value' => function($data){
                      return $data->boardscount;
                }
            ],
           
            ['class' => 'yii\grid\ActionColumn',
             'controller' => 'themeunits'
            ],
        ],
    ]); ?>
</div>
