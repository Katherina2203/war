<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Produce */

$this->title = 'Create Produce';
$this->params['breadcrumbs'][] = ['label' => 'Produces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produce-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
