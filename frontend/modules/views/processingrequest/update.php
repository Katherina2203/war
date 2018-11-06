<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */

$this->title = 'Update Processingrequest: ' . $model->idprocessing;
$this->params['breadcrumbs'][] = ['label' => 'Processingrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idprocessing, 'url' => ['view', 'id' => $model->idprocessing]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="processingrequest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
