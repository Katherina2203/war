<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TypeOfProducts */

$this->title = 'Create Type Of Products';
$this->params['breadcrumbs'][] = ['label' => 'Type Of Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-of-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
