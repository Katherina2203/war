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
        <li role="presentation" class="active"><a href="<?= Url::to(['category/index']) ?>"><?= 'Products by Category' ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['category/bymanufacturer']) ?>"> <?=  'Manufactureres by Category' ?></a></li>
    </ul>
    
    
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
              <?php $form = ActiveForm::begin([
                        'action' => ['category/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchCategory = new backend\models\CategorySearch();
                      $form->field($searchCategory, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search by category']);
                         ?>
                <?php ActiveForm::end(); ?>
                
                <?php $form = ActiveForm::begin([
                        'action' => ['elements/index'],
                        'method' => 'get',
                      ]); ?>
                     <?php $searchElement = new backend\models\ElementsSearch();
                     echo $form->field($searchElement, 'name', [
                         'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
                             Html::submitButton('Search', ['class' => 'btn btn-default']) .
                             '</span></div>',
                         ])->textInput(['placeholder' => 'Search by elements']);
                         ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <p>
        <?php echo Html::a('Создать category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
  
                    <?php 
                        $columns = 3;
                        $cl = 12 / $columns;
                        echo ListView::widget([
                            'dataProvider' =>  $dataProviderParent,
                         //   'layout'       => '{items}{pager}',
                            'options' => ['class' => 'list-wrapper'],
                            'itemOptions'  => ['class' => "col-sm-$cl"],
                            'beforeItem'   => function ($model, $key, $index, $widget) use ($columns) {
                                if ( $index % $columns == 0 ) {
                                    return "<div class='row'>";
                                }
                            },
                            'itemView' => function ($model, $key, $index, $widget) {
                                return $this->render('_categorylist',['model' => $model]);
                            },
                           'afterItem' => function ($model, $key, $index, $widget) use ($columns) {
                                if ( $index != 0 && $index % ($columns - 1) == 0 ) {
                                    return "</div>";
                                }
                            }
                            ]);
                            if ($dataProviderParent->totalCount % $columns != 0) {
                                echo "</div>";
                            }
                        ?>
                 
      
 
</div>
