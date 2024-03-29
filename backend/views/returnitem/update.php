<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Returnitem */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Returnitem',
]) . $model->idreturn;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Returnitems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idreturn, 'url' => ['view', 'id' => $model->idreturn]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="returnitem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
