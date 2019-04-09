<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Закрыть недостачу';
$this->params['breadcrumbs'][] = ['label' => 'Текущие платы', 'url' => ['boards/currentboard']];
$this->params['breadcrumbs'][] = ['label' => $modelboard->name, 'url' => ['boards/view', ['id' => $model->idboart]]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currentboard-closeshortage">

    <?= $this->render('_formcloseshortage', [
        'model' => $model,
        'modelboard' => $modelboard,
    ]) ?>

</div>
