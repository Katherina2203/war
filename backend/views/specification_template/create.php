<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpecificationTemplate */

$this->title = Yii::t('app', 'Create Specification Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specification Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specification-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
