<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Boards */

$this->title = 'Update Boards: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->idboards]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="boards-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
