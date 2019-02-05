<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Prices */

$this->title = $model->idpr;
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-view">

    <h1><?= Html::encode($this->title) ?></h1>
  <?php Pjax::begin(); ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idpr], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idpr], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a('Добавить цену', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idpr',
            [
                'attribute' => 'idel',
                'value' => yii\helpers\ArrayHelper::getValue($model, 'elements.fulname'),
            ],
            [
                'attribute' => 'idsup',
                'value' => yii\helpers\ArrayHelper::getValue($model, 'supplier.name'),
            ],
            [
                'attribute' => 'unitPrice',
                'value' => $model->unitPrice . ' / ' . $model->forUP . ' ' . yii\helpers\ArrayHelper::getValue($model, 'currency.currency'),
            ],
  
            
            [
                'attribute' => 'idcurrency',
                'value' => yii\helpers\ArrayHelper::getValue($model, 'currency.currency'),
            ],
            [
                'attribute' => 'pdv',
                'value' => '+ ' . $model->pdv,
            ],
            
            'usd',
          //  'date',
        ],
    ]) ?>
    </div>
    
    <p>
        <?= Html::a('Добавить товар в счет', ['accounts/addtoinvoice', 'idel' => $model->idel, 'idprice' => $model->idpr], ['class' => 'btn btn-default']) ?>
    </p>
   <?php Pjax::end(); ?>
</div>
