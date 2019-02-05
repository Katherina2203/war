<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RequestStatusHistory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Request Status History',
]) . $model->idreqstatus;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Request Status Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idreqstatus, 'url' => ['view', 'id' => $model->idreqstatus]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="request-status-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
