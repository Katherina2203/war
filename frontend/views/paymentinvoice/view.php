<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = $model->idpaymenti;
$this->params['breadcrumbs'][] = ['label' => 'Paymentinvoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idpaymenti], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idpaymenti], [
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
            'idpaymenti',
            'invoice',
            'date_invoice',
          
            'idpayer',
            'date_payment',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
