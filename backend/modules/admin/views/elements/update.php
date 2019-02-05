<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Elements */

$this->title = 'Update Elements: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->idelements]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="elements-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
