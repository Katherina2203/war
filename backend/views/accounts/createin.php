<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = 'Create Paymentinvoice';
$this->params['breadcrumbs'][] = ['label' => 'Paymentinvoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-createin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formin', [
        'model' => $model,
    ]) ?>

</div>
