<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Purchaseorder */

$this->title = 'Обновить Purchaseorder: ' . $model->idpo;
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpo, 'url' => ['view', 'id' => $model->idpo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchaseorder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
