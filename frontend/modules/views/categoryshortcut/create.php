<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Categoryshortcut */

$this->title = Yii::t('app', 'Create Categoryshortcut');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoryshortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoryshortcut-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
