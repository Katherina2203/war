<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Purchaseorder */

$this->title = 'Обновить Purchaseorder: ' . $model->idpo;
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpo, 'url' => ['view', 'id' => $model->idpo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchaseorder-update col-md-6">
    <div class="box">
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
