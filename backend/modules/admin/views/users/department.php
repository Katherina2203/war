<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники отдела';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 <?php Pjax::begin(['id'=> 'users']); ?>   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'photo',
             //   'label' => 'Photo',
                'format' => 'raw',
                'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                 'value' => function ($model) {
                  //  if($data->image){
                         return Html::img(Yii::getAlias('@web'). '/images/' . $model->photo,//$data['image'],
                               
                         ['width' => '60px']);
                //    }else{
                //        return '<span>no image</span>';
                 //   }
                  // return $model->displayImage;
                },
              /*  'value' => function($data){
                    return Html::img(Url::toRoute($data->photo),[
                        'alt'=>'No image',
                        'style' => 'width:40px;float:center; '
                    ]);
                },*/
            ],
            'name',
            'surname',
            'username',
            // 'password',
            // 'password_hash',
            // 'password_reset_token',
            // 'auth_key',
            'email:email',
       
            [
                'attribute' => 'birthday',
                'format' => 'date',
              //  'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
                ],
                'width' => '160px',
            ],

          

        //    ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?><?php Pjax::end(); ?>
</div>
