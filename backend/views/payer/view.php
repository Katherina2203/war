<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
//kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Payer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payer-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idpayer], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idpayer], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php echo Html::a('Create new', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'idpayer',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            //'label' => '<span class="fa fa-book"></span> Book Details',
                            'value' => function($data){
                               // return '<h2>'. $data->name . '</h2>';
                                return '<h3>' . $data->name . '</h3>';
                            }
                        ],
                        [
                            'attribute' => 'contact',
                            'label' => '<span class="fa fa-user"></span>',
                        ],
                        [
                            'attribute' =>  'phone',
                            'label' => '<span class="fa fa-phone"></span>',
                        ],
                        [
                            'attribute' =>  'email',
                            'label' => '<span class="fa fa-envelope"></span>',
                            'format' => 'raw',
                            'value' => function($data){
                                return $data->email;
                            }
                           // 'email:email',
                        ],
                        [
                            'attribute' =>  'address',
                            'label' => '<span class="fa fa-maps"></span>',
                            'format' => 'raw',
                            'value' => function($data){
                                return Html::encode($data->address);
                            },
                            
                        ],
                       
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
