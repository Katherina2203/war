<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryType */

$this->title = 'Update Category Type: ' . $model->idcategory_type;
$this->params['breadcrumbs'][] = ['label' => 'Category Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcategory_type, 'url' => ['view', 'id' => $model->idcategory_type]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
