<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Недостачи по поставщикам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_searchelements', ['modelelement' => $searchModelelement]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModelelement,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

         //   'idord',
          //  'idelem',
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->elements->name, ['elements/view', 'id' => $model->idelem]);
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
            [
                'attribute' => 'idprice',
                'format' => 'raw',
                'value' => function($data){
                    return $data->prices->price;
                }
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
          //  'idinvoice',
           
          //  'account_date',
            'amount',
           
           // 'idinvoice',
            'delivery',
           
           
            'date_receive',

           
        ],
    ]); ?>
</div>
