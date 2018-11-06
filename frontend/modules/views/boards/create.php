<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Boards */

$this->title = 'Создать плату';
$this->params['breadcrumbs'][] = ['label' => 'Платы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
