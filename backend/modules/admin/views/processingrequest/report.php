<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProcessingrequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Users;
use common\models\Processingrequest;
$this->title = 'Отчет бизнес процесса заявок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idprocessing',
          //  'idrequest',
            [
                'attribute' => 'idrequest',
                'label' => '#Заявки',
            ],
           
            [
                'attribute' => 'idrequest',
                'label' => 'Наименование',
                'value' => 'requests.name'
            ],
        
            [
                'attribute' => 'idrequest',
                'label' => 'Описание',
                'value' => 'requests.description'
            ],
            
            [
                'attribute' => 'idrequest',
                'label' => 'Количество',
                'value' => 'requests.quantity'
            ],
            
            [
                'attribute' => 'idrequest',
                'label' => 'Ожидаемая дата',
                'value' => 'requests.required_date'
            ],
        
            
            [
                'attribute' => 'idrequest',
                'label' => 'Ожидаемая дата от поставщика',
              //  'value' => 'accounts.date_receive'
            ],
            
            [
                'attribute' => 'idrequest',
                'label' => 'Дата получения на склад',
               // 'value' => 'receipt.date_receive'
            ],
            
            'created_at',
            
           
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
