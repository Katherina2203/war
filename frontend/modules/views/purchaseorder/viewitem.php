<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Purchaseorder */

$this->title = $model->idpo;
$this->params['breadcrumbs'][] = ['label' => 'Журнал заказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->idpo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->idpo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'hover'=>true,
        'attributes' => [
            'idpo',
            'idrequest',
            'idelement',
            [
                'attribute' => 'idelement',
                'label' => 'Наименование',
                'value' => ArrayHelper::getValue($model, 'elements.name')
            ],
            [
                'attribute' => 'idelement',
                'label' => 'Номинал',
                'value' => ArrayHelper::getValue($model, 'elements.nominal')
            ],
            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$model->quantity.'</strong>', 
                'displayOnly'=>true,
               //  'inputContainer' => ['class'=>'col-sm-6'] 
            ],
            'date',
            'created_at',
            'updated_at',
         //   'delivery',
        ],
    ]) ?>

</div>
<div class="prices-add">
     <p>
        <?= Html::a('Добавить цену', ['prices/createitem', 'idelement' => $model->idelement], ['class' => 'btn btn-success']) ?>
    </p>
    
   
</div>
