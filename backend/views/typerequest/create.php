<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TypeRequest */

$this->title = Yii::t('app', 'Create Type Request');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
