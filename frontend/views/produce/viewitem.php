<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\elementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //  echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
           // 'idelements',
            [
                'attribute' => 'image',
                'label' => 'Image',
                'format' => 'html',
               // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'value' => function ($data) {
                      return Html::img(Url::to('@web/images/'.$data['image']),/* . $data['image'],*/
                         ['width' => '40px']);
                },
            ],
            
            [
                'attribute' => 'box',
                'label' => 'Расположение',
            ],
           
            [
                'attribute' =>  'name',
                'format'=>'raw',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->name, ['elements/view', 'id' => $model->idelements]);
                },
            ],
            'nominal',
            [
                'attribute' => 'quantity',
                'label' => 'На складе',
                'value' => 'quantity',
                'format' => 'text',
                
            ],
            [
                'attribute' => 'Ordered',
                'label' => 'Заказано',
                'value' =>
                /*function($data){
                     return $data->requests->quantity;
                },*/
                'requests.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],
            [
                'attribute' => 'Reserve',
                'label' => 'Резерв',
                'value' =>'reserve.quantity',
                'format' => 'text',
               // 'filter' => \app\models\Order::getQuantity(),
                
            ],
            [
                'attribute' => 'idcategory',
                'value' => 'category.name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idcategory', ArrayHelper::map(\common\models\Category::find()->select(['name_ru', 'idcategory'])->indexBy('idcategory')->all(), 'idcategory', 'name_ru'),['class'=>'form-control','prompt' => 'Выберите категорию']),
            ],
            [
                'attribute' => 'created_at',
               // 'format' => ['date', 'php:Y-m-d']
            ],
             [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function($data){
                    if($data->active == 1){
                        return '<span class="label label-success">Актуально</span>';
                    }elseif($data->active == 2){
                        return '<span class="label label-danger">Устарело</span>';
                    }
                   
                },
                'filter'=>['1' => 'Актуально', '2' => 'Снято с производства'],
            ],

          
        ],
    ]); ?>
</div>
