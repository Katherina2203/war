<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Elements */

$this->title = 'Create Elements';
$this->params['breadcrumbs'][] = ['label' => 'Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
