<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */

$this->title = 'Update Themeunits: ' . $model->idunit;
$this->params['breadcrumbs'][] = ['label' => 'Themeunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idunit, 'url' => ['view', 'id' => $model->idunit]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="themeunits-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
