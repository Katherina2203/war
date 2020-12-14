<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OutofstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Взято со склада';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['elements/index']];
/*$this->params['breadcrumbs'][] = ['label' => '$model->idelement', 
    'url' => ['view']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-index">

    <h1><?= $element->name . ', ' . $element->nominal?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <p>
            <?= Html::a('<i class="fa fa-external-link"></i> Взять со склада', ['createfrom',  'idel' => $element->idelements, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>

        </p>
        <p style="float:right">
            <?= Html::a('Вернуть на склад', ['createreturn', 'idel' => $element->idelements, 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-default'])?>
        </p>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idofstock',
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
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
            ],
            [
                'attribute' => 'idthemeunit',
                'value' => 'themeunits.nameunit',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'nameunit'),['class'=>'form-control','prompt' => 'Выберите модуль']),
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
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
