<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отдел';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
           // 'label' => 'Photo',
            'format' => 'raw',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            'value' => function($data){
                return Html::img(Url::toRoute($data->photo),[
                    'alt'=>'No image',
                    'style' => 'width:40px;float:center; '
                ]);
            },
            ],
            [
                'attribute' => 'name',
                'label' => 'Имя',
             ],
            'surname',
            'username',
            'birthday',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
