<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ElementsCases */

$this->title = Yii::t('app', 'Create Elements Cases');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Elements Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-cases-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
