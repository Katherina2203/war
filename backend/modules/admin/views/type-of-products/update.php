<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TypeOfProducts */

$this->title = 'Update Type Of Products: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Type Of Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->idtype]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="type-of-products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
