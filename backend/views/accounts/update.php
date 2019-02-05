<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accounts */

$this->title = 'Update Accounts: ' . $model->idord;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idord, 'url' => ['view', 'id' => $model->idord]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accounts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'receipt' => $receipt,
    ]) ?>

</div>
