<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */

$this->title = 'Назначить исполнителя';
$this->params['breadcrumbs'][] = ['label' => 'Назначение исполнителя заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-createExecute">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formex', [
        'model' => $model,
    ]) ?>

</div>
