<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;

use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Produce */

$this->title = $model->manufacture;
$this->params['breadcrumbs'][] = ['label' => 'Produces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produce-info">
    <div class="row">
         <div class="col-md-10">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-2">
                        <h2 class="box-title"><?= $model->manufacture?></h2>
                    </div>
                    <div class="col-md-8">
                    <p class="m-b-xs">
                        <?= Html::a('Update', ['update', 'id' => $model->idpr], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->idpr], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <p><?= yii::t('app', 'Country of origin: ')?><?= $model->country?></p>
                    <div class="box-footer">
                        <p class="with-border"><?= $model->description?></p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <?php $form = ActiveForm::begin([
                        'action' => ['elements/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchElement = new backend\models\ElementsSearch();
                     echo $form->field($searchElement, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search in elements']);
                         ?>
                <?php ActiveForm::end(); ?>
        <?php Pjax::begin(['id' => 'elements-by-produce']); ?>  
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'striped' => true,
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered'
                ],
                'columns' => [
                    [
                        'attribute' => 'image',
                        'label' => 'Image',
                        'format' => 'raw',
                        'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                        'value' => function ($model) {
                          //  if($data->image){
                                 return Html::img(Yii::getAlias('@web').'/images/' . $model->image,//$data['image'],

                                 ['width' => '60px']);
                        //    }else{
                        //        return '<span>no image</span>';
                         //   }
                          // return $model->displayImage;
                        },
                    ],
                    [
                        'attribute' => 'idelements', 
                        //'filter' => false,
                    ],
                    [
                        'attribute' =>  'box',
                        'contentOptions'=>['style'=>'width: 80px;'],
                    ],
                    [
                       'attribute'=>'name',
                       'format'=>'raw',
                       'value' => function ($model, $key, $index) { 
                            return Html::a($model->name, ['view', 'id' => $model->idelements]);
                        },
                    ],
                    'nominal',
                    [
                        'attribute' => 'quantity',
                        'label' => 'Onstock',
                        'format' => 'raw',
                        'value' => function($data){
                            return '<center><strong>' . $data->quantity.'</strong></center>';
                        },
                        'contentOptions'=>['style'=>'width: 50px;'],
                    ],
                    [
                        'attribute' => 'idcategory',
                       /* 'value' => function ($model) {
                            return empty($model->idcategory) ? '-' : $model->category->name;
                        },*/
                        'value' => 'category.name',
                        'format' => 'text',
                        'filter' => Html::activeDropDownList($searchModel, 'idcategory', Category::getHierarchy(), (['class'=>'form-control','prompt' => 'Выберите категорию'])),
                        'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
                    ],
                    [
                        'attribute' => 'active',
                        'format' => 'raw',
                        'value' => function($data){
                            if($data->active == '1'){
                                return '<span class="label label-success">Актуально</span>';
                            }elseif($data->active == '2'){
                                return '<span class="label label-danger">Устарело</span>';
                            }

                        },
                        'filter'=>['1' => 'Актуально', '2' => 'Снято с производства'],
                        'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>  
      </div>
    </div>

</div>
