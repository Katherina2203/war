<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Payer */

$this->title = 'Create Payer';
$this->params['breadcrumbs'][] = ['label' => 'Payers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
