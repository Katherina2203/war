<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Requests */
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-view">
    <p>
        <?= Html::a('Изменить статус', ['updatestatus', 'idrequest' => $model->idrequest], ['class' => 'btn btn-success']) ?>
    </p>
    <h1>Заявка № <?= Html::encode($model->idrequest)?> - <?= Html::encode($this->title) ?></h1>
    <div class="col-sm-4">
        <h2><?= yii::t('app', 'Current status')?>: </h2>
        <?php
                 if($model->status == '0'){
                        echo '<h3><span class="label label-warning" style="color: #d05d09">Не обработана</span></h3>';
                    }elseif($model->status == '1'){
                        echo '<h3><span class="label label-success" style="color: green"> Активна</span></h3>';
                    }elseif($model->status == '2'){
                        echo '<h3><span class="label label-danger" style="color: #888"> Отмена</span></h3>';
                    }elseif($model->status == '3'){
                        echo '<h3><span class="label label-default">Выполнена</span></h3>';
                    }
        ?>
    </div>
    
<div class="row">
    <div class="col-lg-3">
        <div class="box box-info">
        <?= DetailView::widget([
            'model' => $model,
            'hover'=>true,
            'condensed'=>false,
            'attributes' => [
                'idrequest',
                [
                    'attribute' => 'idtype',
                    'value' => ArrayHelper::getValue($model, 'typeRequest.name')
                ],
                'name',
                'description:ntext',
                [
                    'attribute' => 'quantity',
                    'format'=>'raw', 
                    'value'=>'<strong>'.$model->quantity.'</strong>', 
                    'displayOnly'=>true

                ],
                'required_date',
                [
                    'attribute' => 'idproduce',
                    'value' => $model->idproduce != null ? ArrayHelper::getValue($model, 'produce.manufacture') : '-',
                ],
                [ //who ordered
                    'attribute' => 'iduser',
                    'value' => ArrayHelper::getValue($model, 'users.surname'),

                ],
                [
                    'attribute' => 'idproject',
                    'value' => ArrayHelper::getValue($model, 'themes.name')
                ],
                [
                    'attribute' => 'idsupplier',
                    'value' => $model->idsupplier !=null ? ArrayHelper::getValue($model, 'supplier.name') : '-',
                ],
                'created_at',
                [
                    'attribute' => 'estimated_executor',
                   // 'label' => 'Исполнитель',
                    'value' => $model->estimated_executor != null ? ArrayHelper::getValue($model, 'users.surname') : '-', 
                    'visible' => \Yii::$app->user->can('users.surname'),
                ],
                'note',
                [
                    'attribute' => 'estimated_category',
                    'value' => $model->estimated_category !=null ? ArrayHelper::getValue($model, 'category.name'): '-',
                ],
        /*        [   'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'status',
                    'label'=>'Актуальность',
                    'format'=>'raw',
                    'value'=> 
                    $model->status == 0 ? '<span class="warning" style="color: #d05d09">Не обработано</span>' : '<span class="success" style="color: green">Актуально</span>',
                    //$model->status ? 
                    //     '<span class="label label-success">Актуально</span>' : '<span class="label label-danger">Закрыто</span>',
                   // 'type'=>DetailView::INPUT_SWITCH,
                    'widgetOptions'=>[
                            'pluginOptions'=>[
                                '0'=>'Не обработано',
                                '1'=>'Актуально',
                                '2'=>'Отмена',
                                '3'=>'Выполнено',
                            ]
                    ]
                ],*/
             /*    [  
                'attribute' => 'status',
                'label'=>'Актуальность',
                'format'=>'raw',
                'view' => function($model){
                    return '<span class="label label-warning" style="color: #d05d09">'. '</span>';
                }
              /*  'view' => function($model){
                    if($model->status == '0'){
                        echo '<span class="label label-warning" style="color: #d05d09">no active</span>';
                    }elseif($model->status == '1'){
                        echo '<span class="label label-success" style="color: green"> active</span>';
                    }elseif($model->status == '2'){
                        echo '<span class="label label-danger" style="color: #888"> cancel</span>';
                    }elseif($model->status == '3'){
                        echo '<span class="label label-default">done</span>';
                    }
                  }*/
         //   ]
        ],
    ]) ?> 
     <?php // Html::img(Url::to(Yii::$app->request->baseUrl.'/images/no data.jpg'.$modelelement->image), ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image']);?>
    </div>
</div>
  
    <!-- end class row-->
</div>

   
    

    
