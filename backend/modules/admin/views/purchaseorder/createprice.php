<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Prices */

$this->title = 'создать цену';
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcreateprice', [
        'model' => $model,
    ]) ?>

</div>
