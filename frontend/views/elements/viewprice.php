<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PricesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Просмотр цены';
//$this->params['breadcrumbs'][] = $this->title;


$this->title = 'Просмотр цены'. $modelEl->name;
$this->params['breadcrumbs'][] = ['label' => $modelEl->name, 'url' => ['view', 'id'=> $model->idel]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
      <div class="col-sm-2" >
        <div class="box box-solid box-success">
        <?php // Html::img(Yii::$app->params['uploadPath'] = \yii::$app->basePath . '/web/images/capacitor/' . $model->image, ['max-width'=>'300', 'max-heigth' => '300'],['alt' => 'image'])?>
         <?= Html::img(Yii::getAlias('@web').'/images/' . $modelEl->image, ['width'=>'200', 'heigth' => '200'],['alt' => 'image'])?>
        </div>
    </div>
     <div class="col-md-4">
      <div class="box box-solid box-success">
        <div class="box-body">
        <?= DetailView::widget([
            'model' => $modelEl,
            'condensed'=>false,
          /*  'panel' => [
                'heading' => $this->title,
                'type' => DetailView::TYPE_INFO,
                'toolbar' => false,
            ],*/
            'hover'=>true,
            'attributes' => [
                'idelements',
   
            'box',
            'name',
            'nominal',
            [
                'attribute' => 'quantity',
                'format'=>'raw', 
                'value'=>'<strong>'.$modelEl->quantity.'</strong>', 
                'displayOnly'=>true,
               //  'inputContainer' => ['class'=>'col-sm-6'] 
            ],
            [
                'attribute' => 'idproduce',
                'value' => ArrayHelper::getValue($modelEl, 'produce.manufacture')
            ],
            [
                'attribute' => 'idcategory',
                'value' => ArrayHelper::getValue($modelEl, 'category.name_ru')
             /*   'value' => function($model){
                    return Html::a((ArrayHelper::getValue($model, 'category.name_ru')), ['category/items', 'id' => $model->idcategory]);
                }*/
            ],
         
            'created_at',
            'updated_at',
            [
                'attribute' => 'active',
                'label'=>'Актуальность',
                'format'=>'raw',
                'value'=>$modelEl->active ==1 ? '<span class="label label-success">Актуально</span>' : '<span class="label label-danger">Устарело</span>',
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
</div>
<div class="prices-viewprice">
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'unitPrice',
                'value' => function($price){
                    return $price->price;
                }
            ],
            'pdv',
            'usd',
            'created_at',
        ],
    ]); ?>
</div>
