<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\OutofstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Взято со склада';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-index">

    <h1><?= $element->name . ', ' . $element->nominal?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <p>
            <?= Html::a('Вернуть на склад', ['createreturn', 'idel' => $element->idelements, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-default'])?>
            <?= Html::a('<i class="fa fa-external-link"></i> Взять со склада быстро', ['createfromquick',  'idel' => $element->idelements, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('<i class="fa fa-external-link"></i> Взять со склада', ['createfrom',  'idel' => $element->idelements, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>

        </p>

    </div>
     <div class="col-md-4">
      <div class="box">
        <div class="box-body">
        <?= DetailView::widget([
            'model' => $element,
            'condensed'=>false,
            'hover'=>true,
            'attributes' => [
                'idelements',
           /*    [
                'attribute' => 'image',
                'value' => Yii::getAlias('@web').'/images/' . $model->image,
                //  return $model->image;
             //   },
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],*/
            'box',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> call_user_func(function($data){
              //  return '<strong>'.$data->name. '</strong>';
                    return Html::a($data->name, ['elements/view', 'id' => $data->idelements]);
                }, $element),
            ],
            
            'nominal',
            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$element->quantity.'</strong>', 
                'displayOnly'=>true,
               //  'inputContainer' => ['class'=>'col-sm-6'] 
            ],
            [
                'attribute' => 'idproduce',
                'format' => 'raw',
                //'value' => ArrayHelper::getValue($element, 'produce.manufacture')
                'value' => call_user_func(function($data){
                    return Html::a((ArrayHelper::getValue($data, 'produce.manufacture')), ['produce/info', 'idpr' => $data->idproduce]);
                }, $element)
            ],
            [
                'attribute' => 'idcategory',
               // 'value' => ArrayHelper::getValue($element, 'category.name_ru'),
                'format' => 'raw',
                'value' => call_user_func(function($data){
                    return Html::a((ArrayHelper::getValue($data, 'category.name')), ['category/items', 'id' => $data->idcategory]);
                }, $element)
            ],
         
            'created_at',
            'updated_at',
            [
                'attribute' => 'active',
                'label'=>'Актуальность',
                'format'=>'raw',
                'value'=>$element->active ==1 ? '<span class="label label-success" >Актуально</span>' : '<span class="label label-danger">Устарело</span>',
              // 'type' => DetailView::ELEMENT_ACTIVE,
               'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Актуально',
                        'offText' => 'Устарело',
                    ]
                ],

              ],
            ],
         ]) ?>
        </div>
      </div>
    </div>
    <div class="row">
        <div class='col-sm-12'>
            <div class="box-body">
                <?php
                    echo $this->render('_view_outofstock', [
                        'dataProviderout' => $dataProvider,
                        'searchModelout' => $searchModel,
                    ]) 
                ?>
            </div>
        </div>
    </div>
</div>
