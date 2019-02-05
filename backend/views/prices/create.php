<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Prices */

$this->title = 'Create Prices';
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
