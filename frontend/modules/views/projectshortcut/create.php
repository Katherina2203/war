<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Projectshortcut */

$this->title = Yii::t('app', 'Create Projectshortcut');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projectshortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projectshortcut-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
