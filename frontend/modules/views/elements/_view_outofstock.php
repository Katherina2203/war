<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProviderout,
    'filterModel' => $searchModelout,
    'showOnEmpty' => true,
    'emptyText' => '<table><tbody></tbody></table>',
    'class' => 'kartik\grid\EditableColumn',
    'columns' => [
        'idofstock',
        [
            'attribute' => 'users_surname',
            'filter' => Html::activeDropDownList($searchModelout, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Select user']),
        ],
        [
            'attribute' => 'quantity',
            'format' => 'raw',
            'value' => function($data){
                return '<strong><center>' . $data->quantity . '</center></strong>';
            }
        ],
        'date_only',
        [
            'attribute' => 'themes_name',
            'format' => 'raw',
            'value' => function($data) {
                return ((mb_strlen($data->themes_name) > 20) ? mb_substr($data->themes_name, 0, 20) . "..." : $data->themes_name);
            },
            'filter' => Html::activeDropDownList($searchModelout, 'idtheme', ArrayHelper::map(\common\models\Themes::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'ThemList'),['class'=>'form-control','prompt' => 'Выберите проект']),
        ],
        [
            'attribute' => 'themeunits_nameunit',
            'format' => 'raw',
            'value' => function($data) {
                return ((mb_strlen($data->themeunits_nameunit) > 20) ? mb_substr($data->themeunits_nameunit, 0, 20) . "..." : $data->themeunits_nameunit);
            },
            'filter' => Html::activeDropDownList($searchModelout, 'idthemeunit', ArrayHelper::map(\common\models\Themeunits::find()->select(['idunit', 'nameunit'])->all(), 'idunit', 'UnitsListId'),['class'=>'form-control','prompt' => 'Выберите модуль']),
        ], 
        [
            'attribute' => 'boards_idboards_name',
            'format' => 'raw',
            'value' => function($data) {
                return ((mb_strlen($data->boards_idboards_name) > 30) ? mb_substr($data->boards_idboards_name, 0, 30) . "..." : $data->boards_idboards_name);
            },
            'filter' => Html::activeDropDownList($searchModelout, 'idboart', ArrayHelper::map(\common\models\Boards::find()->select(['idboards', 'name'])->where(['discontinued' => '1'])->all(), 'idboards', 'BoardnameId'),['class'=>'form-control','prompt' => 'Выберите плату']),
        ], 
        'ref_of_board',
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'outofstock',
            'template' => '{update} {delete}',
        ],           
    ]
]) ?>
<?php Pjax::end(); ?>