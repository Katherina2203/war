<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дни рождения отдела';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => [
            [
                'attribute' => 'photo',
                'label' => 'Image',
                'format' => 'raw',
                'contentOptions' => ['style' => 'max-width: 80px;white-space: normal'],
                'value' => function ($model) {
                 //  if($model->photo){
                         return Html::img(Yii::getAlias('@web').'/images/users/' . 'no-photo.png',
                         ['width' => '80px']);
                },
            ],
            [
                'attribute' => 'name',
                'label' => 'Фамилия и имя',
                'value' => function($model){
                    return $model->getUserName();
                }
             ],
            [
                'attribute' => 'username',
                'label' => 'Логин',
            ],
            [
                'attribute' => 'birthday',
                'label' => 'День рождения',
                'format' => ['date', 'php:d-m-Y'],
                'value' => $model->birthday,

            ],

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
