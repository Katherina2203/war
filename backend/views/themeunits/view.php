<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */

$this->title = $model->idunit;
$this->params['breadcrumbs'][] = ['label' => 'Themeunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="row"><div class="col-md-6">
         
<div class="themeunits-view">
    <div class="box box-solid box-default">
        <div class="box-header with-border"><h3 class="box-title">Модули проекта -  <?php echo $model->themes->name; ?></h3></div>
                <div class="box-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idunit], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idunit], [
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
            'idunit',
            [
                'attribute' => 'idtheme',
                'value' => function($data){
                    return $data->themes->name;
                }
            ],
            
            'nameunit',
            'quantity_required',
            'created_at',
        ],
    ]) ?>
         </div> </div>
    </div>
</div>
</div></div>
