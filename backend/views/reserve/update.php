<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reserve */

$this->title = 'Update Reserve: ' . $model->idreserve;
$this->params['breadcrumbs'][] = ['label' => 'Reserves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idreserve, 'url' => ['view', 'id' => $model->idreserve]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reserve-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
