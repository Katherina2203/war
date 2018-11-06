<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Themes */

$this->title = 'Create board';
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-create">
    
    <?= $this->render('_formboard', [
        'model' => $model,
    ]) ?>

</div>
