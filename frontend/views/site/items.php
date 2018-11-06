<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ElementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Elements by category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?= Html::encode($model->category);?></h2>
    <?php //  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Elements', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idelements',
            'box',
            'name',
            'nominal',
            [
                'attribute' => 'idproduce',
                'value' => 'produce.manufacture'
            ],
                
            
           //  'idcategory',
            [
            'label' => 'Image',
            'format' => 'raw',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            'value' => function($data){
                return Html::img(Url::toRoute($data->image),[
                    'alt'=>'No image',
                    'style' => 'width:40px;float:center; '
                ]);
            },
            ],
            //'date_added',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
