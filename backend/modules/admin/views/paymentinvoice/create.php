<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Paymentinvoice */

$this->title = 'Создать счет';
$this->params['breadcrumbs'][] = ['label' => 'Текущие счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentinvoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
