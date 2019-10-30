<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use common\models\Category;
use common\models\Elements;
use common\models\Produce;

$this->title = yii::t('app', 'Elements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-index">
    <p><?php echo Html::a(yii::t('app', 'Create new element'), ['create'], ['class' => 'btn btn-success']) ?></p>
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <?php  
                    echo $this->render('_search', [
                        'model' => $searchModel, 
                        'aCategoryHierarchy' => $aCategoryHierarchy,
                        'aProduce' => $aProduce,
                    ]);
                ?>
            </div>
        </div>
    </div>
   
<?php 
    //Pjax::begin(['id' => 'elements']); 
?>  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'pjax' => true,
//        'striped' => true, //полосатый стиль
//        'condensed' => true,
//        'responsive' => true,
//        'hover' => true,
//        'resizableColumns' => true,
//        'tableOptions' => [
//            'class' => 'table table-striped table-bordered'
//        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'columns' => [
            [
                'attribute' => 'idelements', 
                'contentOptions' => ['style' => 'width: 40px;'],
            ],
            [
                'attribute' => 'box',
                'contentOptions' => ['style' => 'width: 60px;'],
            ],
            [
               'attribute' => 'name',
               'format' => 'raw',
               'value' => function($model, $key, $index) {
                    return Html::a($model->name, ['view', 'id' => $model->idelements]);
                },
            ],
            [
                'attribute' => 'nominal',
                'contentOptions' => ['style' => 'word-wrap: break-word'],
            ],
            [
                'attribute' => 'quantity',
                'label' => 'Onstock',
                'format' => 'raw',
                'value' => function($model, $index) {
                    $sQty = '<center><strong>' . $model->quantity . '</strong></center>';
                    if (!is_null($model->date_receive)) {
                        return $sQty . '<center><small>Will be: ' . $model->expacted_quantity . ' (' . $model->date_receive . ')' . '</small></center>';
                    }
                    return $sQty;
                },
                'contentOptions' => ['style'=>'width: 50px;'],
            ],
            [
                'attribute' => 'manufacture',
                'value' => function($model){
                    return Html::a($model->manufacture, ['produce/viewitem', 'id' => $model->idproduce]);
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'idproduce', $aProduce, ['class'=>'form-control','prompt' => yii::t('app', 'Choose manufacturer')]),
                'contentOptions' => ['style' => 'word-wrap: break-word; width: 14%;'],
            ],
            [
                'attribute' => 'category_name',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idcategory', $aCategoryHierarchy, (['class'=>'form-control','prompt' => yii::t('app', 'Choose category')])),
                'contentOptions' => ['style' => 'word-wrap: break-word; width: 14%'],
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function($data) {
                    if ($data->active == '1') {
                        return '<span class="label label-success">Актуально</span>';
                    } elseif ($data->active == '2') {
                        return '<span class="label label-danger">Устарело</span>';
                    }
                   
                },
                'filter' => ['1' => 'Актуально', '2' => 'Устарело'],
                'contentOptions' => ['style' => 'max-width: 90px;white-space: normal'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:45px;'],
                'template' => ' {prices} {viewfrom}',
                'buttons' => [
                    'prices' => function($url,$model,$key) {
                        $url = Url::to(['viewprice', 'idel' => $key]);
                        return Html::a('<span class="glyphicon glyphicon-euro"></span>', $url, ['title' => 'Посмотреть цену']);
                    },
                    'viewfrom' => function($url,$model,$key) {
                        $url = Url::to(['viewfrom', 'idel' => $key]);
                        return Html::a('<span class="glyphicon glyphicon-minus"></span>', $url, ['title' => 'Посмотреть что взято со склада']);
                    },
                    'urlCreator' => function($action, $model, $key, $index) {
                        if ($action === 'receipt') {
                            $url = yii::$app->controller->createUrl('receipt');
                            return $url;
                        }
                        if ($action === 'prices') {
                            $url ='prices/view?idelement='.$model->idel;
                            return $url;
                        }
                    },
                ],
            ],
        ],
    ]); ?>
<?php 
    // Pjax::end(); 
?>  
</div>
