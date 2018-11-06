<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ElementsCases */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Elements Cases',
]) . $model->idelement;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Elements Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idelement, 'url' => ['view', 'id' => $model->idelement]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="elements-cases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
