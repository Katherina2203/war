<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Prices */

$this->title = $model->idpr;
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'idel',
            'idsup',
            'unitPrice',
            'forUP',
            'idcurrency',
            'pdv',
            'usd',
          //  'date',
        ],
    ]) ?>
    </div>
    <div class="col-md-6">
        <?php
        if(yii::$app->user->can('admin') or yii::$app->user->can('Purchasegroup')){
            echo Html::a('Добавить в счет', ['create'], ['class' => 'btn btn-success']);
        }

        ?>
    </div>
    
</div>
