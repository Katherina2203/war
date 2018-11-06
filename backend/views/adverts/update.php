<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Adverts */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Adverts',
]) . $model->idadvert;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idadvert, 'url' => ['view', 'id' => $model->idadvert]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="adverts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
