<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Update Outofstock: ' . $model->idofstock;
$this->params['breadcrumbs'][] = ['label' => 'Outofstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idofstock, 'url' => ['view', 'id' => $model->idofstock]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="outofstock-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
