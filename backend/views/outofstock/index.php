<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OutofstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Взято со склада';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Взять со склада', ['create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idofstock',
            'idelement',
            [
                'attribute' => 'iduser',
                'value' => 'users.surname',
                
                  'filter' => Html::activeDropDownList($searchModel, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Select user']),
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
            'date',
         //   'idtheme',
            [
                'attribute' => 'idtheme',
                'value' => function($data){
                    return $data->themes->ThemList;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'ThemList'),['class'=>'form-control','prompt' => 'Выберите проект']),
            ],
            [
                'attribute' => 'idthemeunit',
                'value' => 'themeunits.UnitsListId',
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'UnitsListId'),['class'=>'form-control','prompt' => 'Выберите модуль']),
            ], 
            [
                'attribute' => 'idboart',
                'value' => function($data){
                    return $data->boards->BoardnameId;
                },
                'format' => 'text',
                'filter' => Html::activeDropDownList($searchModel, 'idboart', ArrayHelper::map(\common\models\Boards::find()->select(['idboards', 'name'])->where(['discontinued' => '1'])->all(), 'idboards', 'BoardnameId'),['class'=>'form-control','prompt' => 'Выберите плату']),
            ], 
            'ref_of_board',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
 
</div>
