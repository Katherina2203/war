<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Создать перечень';
$this->params['breadcrumbs'][] = ['label' => 'Платы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-create-quicklist">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formquick', [
        'model' => $model,
    ]) ?>

</div>
