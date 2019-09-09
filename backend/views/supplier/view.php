<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Supplier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Поставщики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-view">
    <p><?= Html::a('<i class="glyphicon glyphicon-plus"></i> new supplier', ['create'], ['class' => 'btn btn-success']) ?></p>
    
    <div class="row">
        <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border"><span>Supplier: </span><h2 class="box-title"><?= $model->name?></h2></div>
                <div class="box-body">
                    <p>
                       <?= Html::a('Update', ['update', 'id' => $model->idsupplier], ['class' => 'btn btn-primary']) ?>
                       <?= Html::a('Delete', ['delete', 'id' => $model->idsupplier], [
                           'class' => 'btn btn-danger',
                           'data' => [
                               'confirm' => 'Are you sure you want to delete this item?',
                               'method' => 'post',
                           ],
                       ]) ?>
                    </p>
                    <div class="box box-solid box-success">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'idsupplier',
                                'name',
                                'address',
                                'manager',
                                'phone',
                                [
                                    'attribute' => 'logo',
                                    'value' => function($data){
                                        return empty($data->logo) ? '-' : $data->logo;
                                    }
                                ],
                                [
                                    'attribute' => 'website',
                                    'format' => 'raw',
                                    'value' => function($data){
                                        return html::a($data->website, $data->website);
                                    }
                                ],
                                
                            ],
                        ]) ?>
                    </div>
                </div>
            </div><!-- /end .box -->
        </div><!-- /end .col-md-10 -->
    </div>
    <div class="row">
        <div class="col-md-10">
            
        </div>
    </div>
   

   

</div>
