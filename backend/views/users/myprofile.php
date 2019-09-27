<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мой профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?php // Html::encode($this->title) ?></h1>

   

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Мои данные',
                'content' =>  $this->render('viewmyprofile', ['model' => $model]),
                'active' => true // указывает на активность вкладки
            ],
            [
                'label' => 'Обновить фото',
                 'content' =>  $this->render('_foto', ['model' => $model]),

            ],
     /*   [
            'label' => 'Пароль',
            'content' =>  $this->render('changepassword', ['model' => $model]),
            'headerOptions' => [
                'id' => 'someId'
            ]
        ],*/
       /* [
            'label' => 'Radar site',
            'url' => 'http:\\www.radar.kharkov.ua',
        ],*/
      /*  [
            'label' => 'Dropdown',
            'items' => [
                [
                    'label' => '1',
                    'content' => 'Выпадашка 1'
                ],
                [
                    'label' => '2',
                    'content' => 'Выпадашка 2'
                ],
                [
                    'label' => '3',
                    'content' => 'Выпадашка 3'
                ],
            ]
        ]*/
    ]
]);
?>

</div>