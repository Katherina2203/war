<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Categoryshortcut */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Categoryshortcut',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoryshortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categoryshortcut-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
