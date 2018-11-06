<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = 'Update Paymentinvoice: ' . $model->idpaymenti;
$this->params['breadcrumbs'][] = ['label' => 'Paymentinvoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpaymenti, 'url' => ['view', 'id' => $model->idpaymenti]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paymentinvoice-edit-invoice">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formeditinvoice', [
        'model' => $model,
    ]) ?>

</div>
