<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = 'Добавить в счет';
$this->params['breadcrumbs'][] = ['label' => 'Оплачиваемые счета', 'url' => ['paymentinvoice/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formadditem', [
        'modelPayment' => $modelPayment,
        'modelsAccounts' => $modelsAccounts,
    ]) ?>

</div>
