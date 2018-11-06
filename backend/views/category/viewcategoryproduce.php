<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">
    <div class="row">
        <div class="col-md-10">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-2">
                        <span><?= yii::t('app', 'Category:')?></span><h2 class="box-title"><?= $model->name?></h2>
                    </div>
                    <div class="col-md-8">
                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->idcategory], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->idcategory], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            
                        </p>
                        
                        <div class="box-footer">
                            <p>
                                <?= Html::a('Add manufacturer', ['createcategmanufacture', 'id' => $model->idcategory], ['class' => 'btn btn-success']) ?>
                            </p>
                            <?= ListView::widget([
                                'dataProvider' => $dataProvider,
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'list-wrapper',
                                    'id' => 'list-wrapper',
                                ],
                            //    'layout' => "{pager}\n{items}\n{summary}",
                                'itemView' => function ($model, $key, $index, $widget) {
                                    return $this->render('_producelist',['model' => $model]);

                                  //  return Html::a($model->produce->manufacture, ['produce/info', 'idpr' => $model->idproduce]) . '<br/>';
                                },
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'emptyText' => '<p>Список пуст</p>',
                                 'summary' => 'Показано {count} из {totalCount}',
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
