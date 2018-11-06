<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Projectshortcut */

$this->title = $model->idshortcut;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projectshortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projectshortcut-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idshortcut], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idshortcut], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a(Yii::t('app', 'Create Projectshortcut'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idshortcut',
            'description',
            'status',
        ],
    ]) ?>

</div>
