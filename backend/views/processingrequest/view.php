<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */

$this->title = $model->idprocessing;
$this->params['breadcrumbs'][] = ['label' => 'Processingrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idprocessing], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idprocessing], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
         <p>
        <?= Html::a('Добавить исполнителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idprocessing',
            'idpurchasegroup',
            'idresponsive',
            'idrequest',
            'created_at',
         //   'updated_at',
            
        ],
    ]) ?>

</div>
