<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Returnitem */

$this->title = $model->idreturn;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Returnitems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returnitem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idreturn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idreturn], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idreturn',
            'idelement',
            'quantity',
            'created_at',
           // 'updated_at',
        ],
    ]) ?>

</div>
