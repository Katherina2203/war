<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use yii\bootstrap\ActiveForm;
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
            <?= Html::a('<i class="fa fa-external-link"></i> Взять со склада', ['createfrom',  'idel' => $element->idelements, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>

        </p>
      
           
  
    </div>
     <div class="col-md-4">
      <div class="box">
        <div class="box-body">
        <?= DetailView::widget([
            'model' => $element,
            'condensed'=>false,
            /*   'panel' => [
                'heading' => $this->title,
                'type' => DetailView::TYPE_INFO,
                'toolbar' => false,
            ],*/
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idofstock',
            [
                'attribute' => 'iduser',
                'value' => 'users.surname'
            ],
            'quantity',
            'date',
            [
                'attribute' => 'idtheme',
                'value' => 'themes.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->all(), 'idtheme', 'name'),['class'=>'form-control','prompt' => 'Выберите проект']),
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
            ],
            [
                'attribute' => 'idthemeunit',
                'value' => 'themeunits.nameunit',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'nameunit'),['class'=>'form-control','prompt' => 'Выберите модуль']),
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
            ],
            [
                'attribute' => 'idboart',
                'value' => 'boards.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idboart', ArrayHelper::map(\common\models\Boards::find()->select(['idboards', 'name'])->all(), 'idboards', 'name'),['class'=>'form-control','prompt' => 'Выберите плату']),
            ],
            'ref_of_board',
            [
             'class' => 'yii\grid\ActionColumn',
             'controller' => 'outofstock',
            ],
        ],
    ]); ?>
</div>
