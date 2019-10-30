<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use common\models\Category;

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="<?= Url::to(['category/index']) ?>"><?= 'Products by Category' ?></a></li>
        <li role="presentation"><a href="<?= Url::to(['category/bymanufacturer']) ?>"> <?= 'Manufactureres by Category' ?></a></li>
    </ul>
    <div class="search-form">
        <div class="box box-solid bg-gray-light" style="background: #fff;">
            <div class="box-body">
                <span>Поиск по:</span>
                <?php 
                    $form = ActiveForm::begin(['action' => ['category/index'], 'method' => 'get',]);  
                    echo $form->field($searchModel, 'name', ['template' => '<div class="input-group">{input}<span class="input-group-btn">' . Html::submitButton('Search', ['class' => 'btn btn-default']) . '</span></div>',])->textInput(['placeholder' => 'Search by category']);
                    ActiveForm::end(); 
                ?>
            </div>
        </div>
    </div>
    <p><?php echo Html::a('Создать category', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderCategory,
        'containerOptions' => ['style' => 'overflow: auto'],
        'rowOptions' => function($model, $key, $index, $grid) {
            if ($model->parent == '0') {
                return ['style' => 'background-color: #d5d8db; font-weight: bold;'];
            }else{
                return ['style' => 'background-color: #f9fafc;'];
            }
           
        },
        'formatter' => [
            'class' => yii\i18n\Formatter::className(),
            'nullDisplay' => '',
        ],

                //['nullDisplay' => ''],
        'columns' => [
            [
                'attribute' => 'idcategory',
                'contentOptions' => ['style' => 'width: 20px;'],
            ],
            'name',
            'name_ru',
            'url',
            'parent_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:45px;'],
                'template' => '{update} {delete}',// {delete}
//                'buttons' => [
//                    'delete' => function($url, $model, $key) {
//                        $url = Url::to(['viewfrom', 'idel' => $key]);
//                        return Html::a('<span class="glyphicon glyphicon-minus"></span>', $url, ['title' => 'Посмотреть что взято со склада']);
//                    },
//                ],
            ],
        ],
    ]);
    ?>
</div>
