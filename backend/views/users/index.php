<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
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
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
            'label' => 'Photo',
            'format' => 'raw',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            'value' => function($data){
                return Html::img($data->photo,[
                    'alt'=>'No image',
                    'style' => 'width:40px;float:center; '
                ]);
            },
            ],
            'name',
            'surname',
            'username',
            // 'password',
            // 'password_hash',
            // 'password_reset_token',
            // 'auth_key',
            'email:email',
            'role',
            'status',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
