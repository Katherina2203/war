<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shortage */

$this->title = 'Update Shortage: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shortages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shortage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
