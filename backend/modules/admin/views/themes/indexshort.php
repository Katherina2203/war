<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use common\models\Themes;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Текущие проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'idtheme',
          //  'projectnumber',
          //  'name',
            [
                'attribute' => 'name',
                 'value' => function (Themes $data) {
                      return Html::a(Html::encode($data->name), Url::to(['units', 'id' => $data->idtheme]));
                },
                'format' => 'raw',
            ],
           // 'full_name',
         //   'customer',
          //  'description:ntext',
          //  'subcontractor',
            'quantity',
          //  'date',
          //  'status',

            [
                'attribute' => 'units_count',
                'label' => 'Количество модулей',
                'format' => 'text',
                /*'value' => function($data){
                        return $data->unitscount;
                   }*/
            ],
            ['class' => 'yii\grid\ActionColumn'],
             
        
        ],
    ]); ?>
</div>
