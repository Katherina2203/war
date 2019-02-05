<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
//use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Supplier; 
use common\models\Produce;
use common\models\Themes;
use common\models\Users;
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    
    ];

$this->title = 'Мои заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-index">

    
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
   <p>
        <?= Html::a('Создать заявку', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
         'rowOptions' => function($model, $key, $index, $grid){
            if($model->status == '0'){  // not active
                return ['class' => 'warning'];  //active class => 'sucess'   label label-primary glyphicon glyphicon-ok
            }elseif($model->status == '1'){  //active
                 return ['class' => 'success']; //unactive color: #b2b2b2 label label-danger glyphicon glyphicon-remove
            }elseif($model->status == '2'){ //cancel
                return ['style' => 'label label-default glyphicon glyphicon-time']; //cancel f97704 - orange color:#c48044
            }elseif($model->status = '3'){ //done
                return ['style' => 'color:#b2b2b2'];
            }
        },
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'columns' => $gridColumns,
        'resizableColumns'=>true,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            
            [
              'attribute' => 'idrequest',
              'label' =>'#Заявки'
            ],
            
            [
              'attribute' => 'name',
               'format'=>'raw',
               'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['view', 'id' => $model->idrequest]);
                },
            ],
            'description',
            [
                'attribute' => 'quantity',
                'format'=>'raw',
                'value'=>function ($data){
                return '<strong>'.$data->quantity.'</strong>';
                }
            ],
            'required_date',
            [
                'attribute' => 'idproject',
                'value' => 'themes.name',
                 'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', ArrayHelper::map(\common\models\Themes::find()->asArray()->all(), 'idtheme', 'name'), ['class' => 'form-control', 'prompt' => 'Выберите проект'])
            ],
            [
                'attribute' => 'idproduce',
                'value' => 'produce.manufacture',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', Themes::find()->select(['name', 'idtheme'])->indexBy('idtheme')->where(['status' => 'active'])->column(), ['class' => 'form-control', 'prompt' => 'Выберите проект'])
            ],
            
            [
                'attribute' => 'idsupplier',
                'value' => 'supplier.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idsupplier', Supplier::find()->select(['name', 'idsupplier'])->indexBy('idsupplier')->column(), ['class' => 'form-control', 'prompt' => 'Выберите поставщика'])
            ],
            [ 'attribute' => 'status',
              'format' => 'html',
              'value'=> function($model){
                    if($model->status == '0'){ //not active
                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Не обработано</span>';
                    }elseif($model->status == '1'){//active
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> Активна</span>';
                    } elseif($model->status == '2'){//cancel
                       return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"> Отменено</span>';
                    }elseif($model->status == '3'){ //done
                       return '<span class="glyphicon glyphicon-saved" style="color:grey"> Выполнено</span>';
                    };
                }
            ],
           
            'created_at',
            //'updated_at',
            'note',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
