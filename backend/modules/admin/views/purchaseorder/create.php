<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Purchaseorder */

$this->title = 'Create Purchaseorder';
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
