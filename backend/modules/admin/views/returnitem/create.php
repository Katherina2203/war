<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Returnitem */

$this->title = Yii::t('app', 'Create Returnitem');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Returnitems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returnitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
