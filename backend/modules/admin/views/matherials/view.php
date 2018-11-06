<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Matherials */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Matherials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matherials-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idmatherial], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idmatherial], [
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
            'idmatherial',
            'storeplace',
            'name',
            'description',
            'date_create',
        ],
    ]) ?>

</div>
