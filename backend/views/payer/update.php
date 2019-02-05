<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Payer */

$this->title = 'Update Payer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->idpayer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
