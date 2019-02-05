<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OutofstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Взято со склада';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        //    ['class' => 'yii\grid\SerialColumn'],

            'idofstock',
          //  'idelement',
            
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
            ],
            [
                'attribute' => 'idthemeunit',
                'value' => 'themeunits.nameunit',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'nameunit'),['class'=>'form-control','prompt' => 'Выберите модуль']),
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
