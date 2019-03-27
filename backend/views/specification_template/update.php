<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpecificationTemplate */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Specification Template',
]) . $model->idspt;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specification Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idspt, 'url' => ['view', 'id' => $model->idspt]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="specification-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
