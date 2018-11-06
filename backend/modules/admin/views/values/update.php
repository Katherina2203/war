<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Values */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Values',
]) . $model->idelement;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idelement, 'url' => ['view', 'id' => $model->idelement]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="values-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
