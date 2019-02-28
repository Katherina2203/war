<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TypeRequest */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Type Request',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->idtype]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="type-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
