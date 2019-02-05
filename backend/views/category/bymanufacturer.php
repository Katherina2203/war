<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Category;
$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="<?= Url::to(['category/index']) ?>"><?= 'Products by Category' ?></a></li>
        <li role="presentation" class="active"><a href="<?= Url::to(['category/bymanufacturer']) ?>"> <?= 'Manufactureres by Category' ?></a></li>
    </ul>
    
    <div class="search-form">
        <div class="box box-solid bg-gray-light">
            <div class="box-body">
                <span>Поиск по:</span>
             
                <?php $form = ActiveForm::begin([
                        'action' => ['produce/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchProduce = new backend\models\ProduceSearch();
                     echo $form->field($searchProduce, 'manufacture', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search in manufacturer']);
                         ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    
    <p>
     <?php echo Html::a('Добавить производителя в категорию', ['createmanufacture'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => [
                                'tag' => 'div',
                                'class' => 'list-wrapper',
                                'id' => 'list-wrapper',
                            ],
                        //    'layout' => "{pager}\n{items}\n{summary}",
                            'itemView' => function ($model, $key, $index, $widget) {
                                return $this->render('_categoryproduce',['model' => $model, 
                                    ]);
                                // return $model->title . ' posted by ' . $model->author;
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
