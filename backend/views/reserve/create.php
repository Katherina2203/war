<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Reserve */

$this->title = 'Create Reserve';
$this->params['breadcrumbs'][] = ['label' => 'Reserves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserve-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
