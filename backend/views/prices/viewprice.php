<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Prices */

$this->title = $model->idpr;
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-view">
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                
                <?php $form = ActiveForm::begin([
                        'action' => ['requests/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchRequest = new backend\models\RequestsSearch();
                     echo $form->field($searchRequest, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search in requests']);
                         ?>
                <?php ActiveForm::end(); ?>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-6">
                        <h2 class="box-title"><?= '<strong>'. $model->idel. '</strong>'. ', ' . ArrayHelper::getValue($model, 'elements.fulname')?></h2>
                    </div>
                    <div class="col-md-8">
                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->idpr], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->idpr], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::a('Добавить цену', ['addprice', 'idel' => $model->idel], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Добавить товар в счет', ['accounts/addtoinvoice', 'idel' => $model->idel, 'idprice' => $model->idpr], ['class' => 'btn btn-default']) ?>
                        </p>

                       
                    <div class="box-footer">
                        <p class="with-border">
                            <?php Pjax::begin(['id' => 'item-price']); ?>
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'idpr',
                                    [
                                        'attribute' => 'idel',
                                        'format' => 'html',
                                        'value' => '<strong>'. $model->idel. '</strong>'. ', ' . ArrayHelper::getValue($model, 'elements.fulname'),
                                    ],
                                    [
                                        'attribute' => 'idsup',
                                        'value' => yii\helpers\ArrayHelper::getValue($model, 'supplier.name'),
                                    ],
                                    [
                                        'attribute' => 'unitPrice',
                                        'value' => $model->unitPrice . ' / ' . $model->forUP . ' ' . yii\helpers\ArrayHelper::getValue($model, 'currency.currency'),
                                    ],


                                    [
                                        'attribute' => 'idcurrency',
                                        'value' => yii\helpers\ArrayHelper::getValue($model, 'currency.currency'),
                                    ],
                                    [
                                        'attribute' => 'pdv',
                                        'value' => '+ ' . $model->pdv,
                                    ],
                                    'usd',
                                  //  'date',
                                ],
                            ]) ?>
                           <?php Pjax::end(); ?>
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'idpr',
                //'idel',
            /*    [
                    'attribute' =>  'idel',
                    'label' => 'Название',
                    'value' => 'elements.name',
                ],
                  [
                    'attribute' =>  'idel',
                    'label' => 'Описание',
                    'value' => 'elements.nominal',
                ],*/
                [
                    'attribute' => 'idsup',
                    'value' => 'supplier.name',
                    'filter' => Html::activeDropDownList($searchModel, 'idsup', ArrayHelper::map(common\models\Supplier::find()->select(['idsupplier', 'name'])->all(), 'idsupplier', 'name'),['class'=>'form-control','prompt' => 'Выберите поставщика']),
                ],
              //  'unitPrice',
                [
                    'attribute' =>  'unitPrice',
                    'value' => function($data){
                        return $data->unitPrice. '/'. $data->forUP;
                    },
                    'format' => 'raw',
                ],

                [
                    'attribute' => 'idcurrency',
                    'format' => 'raw',
                    'value' => 'currency.currency',
                ],
                'pdv',
                'usd',
                'created_at',

                    ['class' => 'yii\grid\ActionColumn'],
                    ],
            ]); ?>
        </div>
    </div>
</div>
