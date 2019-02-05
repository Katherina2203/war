<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Add Manufacture to Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-createmanufacture">

    <?= $this->render('_formcatprod', [
        'model' => $model,
    ]) ?>

</div>
