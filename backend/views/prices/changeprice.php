<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = 'Change price: ' . $model->idpr;
$this->params['breadcrumbs'][] = ['label' => 'Paymentinvoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpr, 'url' => ['view', 'id' => $model->idpr]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prices-changeprice">

    <?= $this->render('_formchangeprice', [
        'model' => $model,
        'modelpay' => $modelpay,
        'modelacc' => $modelacc
    ]) ?>

</div>
