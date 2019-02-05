<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcessingrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Назначение исполнителя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Назначить исполнителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

          //  'idprocessing',
            'idrequest',
           
            [
                'attribute' => 'idresponsive',
                'value' => 'users.surname'
            ],
            
            [
                'attribute' => 'idpurchasegroup',
                'value' => 'user.surname',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idpurchasegroup', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Выберите исполнителя']),
            ],
            
            
            'created_at',
            
         
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
