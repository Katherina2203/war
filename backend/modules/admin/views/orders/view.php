<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idorder], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idorder], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idorder',
            'name',
            'req_quantity',
            'idproduce',
            'idsupplier',
            'req_date',
            'executor',
            'aggr_date',
            'qty',
            'amount',
            'suppl_date',
            'date_payment',
            'contract',
            'date_onstock',
            'date_recept',
            'created_at',
            'updated_at',
            'idtheme',
            'iduser',
            'idstatus',
            'additional',
        ],
    ]) ?>

</div>
