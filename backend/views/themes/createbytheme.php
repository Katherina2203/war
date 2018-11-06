<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */

$this->title = 'Create Themeunits';
$this->params['breadcrumbs'][] = ['label' => 'Themeunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themeunits-createbytheme">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formbytheme', [
        'model' => $model,
    ]) ?>

</div>
