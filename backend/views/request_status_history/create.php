<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RequestStatusHistory */

$this->title = Yii::t('app', 'Create Request Status History');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Request Status Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-status-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
