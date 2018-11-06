<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Взять со склада';
$this->params['breadcrumbs'][] = ['label' => 'Со склада', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-create">

    <?= $this->render('_formst', [
        'model' => $model,
        'idel' => $model->idelement,
        'element' => $element,
       // 'user' => $user,
    ]) ?>

</div>
