<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Receipt */

$this->title = 'Update Receipt: ' . $model->idreceipt;
$this->params['breadcrumbs'][] = ['label' => 'Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idreceipt, 'url' => ['view', 'id' => $model->idreceipt]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="receipt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
