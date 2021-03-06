<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shortage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shortages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'idboard',
            'ref_of',
            'idelement',
            'quantity',
            'created_at',
        ],
    ]) ?>

</div>
