<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Receipt */

$this->title = 'Создать получение';
$this->params['breadcrumbs'][] = ['label' => 'Добавление получения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_formreceipt', [
        'model' => $model,
        'modelacc' => $modelacc,
       // 'modelel' => $modelel,
    ]) ?>

</div>