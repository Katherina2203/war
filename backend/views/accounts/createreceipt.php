<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Accounts */

$this->title = 'Создать получение';
$this->params['breadcrumbs'][] = ['label' => 'Текущие позиции в счете', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-createreceipt">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcreatereceipt', [
        'model' => $model,
    ]) ?>

</div>
