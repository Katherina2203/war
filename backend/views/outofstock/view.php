<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = $model->idofstock;
$this->params['breadcrumbs'][] = ['label' => 'Outofstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idofstock], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idofstock], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Взять со склада', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
  <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
     //   'quantity' => $quantity,
        'attributes' => [
            'idofstock',
            
            [
                'attribute' => 'idelement',
                'value' => $model->idelement. ' '. ArrayHelper::getValue($model, 'elements.name') . ', ' . ArrayHelper::getValue($model, 'elements.nominal')
            ],
            [
                'attribute' => 'iduser',
                'value' => ArrayHelper::getValue($model, 'users.surname')
            ],
            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$model->quantity.'</strong>', 
                'displayOnly'=>true,
               //  'inputContainer' => ['class'=>'col-sm-6'] 
            ],
            'date',
            [
                'attribute' => 'idtheme',
               // 'format'=>'raw', 
                'value' => $model->idtheme . ' ' . ArrayHelper::getValue($model, 'themes.name')
            ],
            [
                'attribute' => 'idthemeunit',
              //  'format'=>'raw', 
                'value' =>  $model->idthemeunit . ' ' . ArrayHelper::getValue($model, 'themeunits.nameunit')
            ],
            [
                'attribute' => 'idboart',
              //  'format'=>'raw', 
                'value' => $model->idboart . ' ' . ArrayHelper::getValue($model, 'boards.name')
            ],
            
            'ref_of_board',
        ],
    ]) ?>
  </div>
</div>

