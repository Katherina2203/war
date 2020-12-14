<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcessingrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="breadcrumb" style="float:left; position: absolute;">
<?php
$this->title = 'Текущее состояние моих заявок';
$this->params['breadcrumbs'][] = $this->title;
?>
    </div>
<div class="processingrequest-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <strong style="padding: 30px; ">Здесь будут выводиться текущее состояние, дата ожидания и статус обработки моих заявок</strong>
    
    
</div>

