<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Prices */

$this->title = 'Обновить цену: ' . $model->idpr;
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpr, 'url' => ['view', 'id' => $model->idpr]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prices-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
