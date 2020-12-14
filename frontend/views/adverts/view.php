<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Adverts */

$this->title = $model->idadvert;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Объявление'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adverts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->idadvert], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->idadvert], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверенны, что хотите удалить данное объявление?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idadvert',
            'iduser',
            'content:ntext',
            'created_at',
            'updated_at',
            'ord',
        ],
    ]) ?>

</div>
