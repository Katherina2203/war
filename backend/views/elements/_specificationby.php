<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
//use yii\widgets\Pjax;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use common\models\Shortage;
 
echo GridView::widget([
    'dataProvider' => $dataProviderShortage,
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'responsive' => false,
    'columns' => 
    [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'quantity', 
            'format'=>'raw',
            'value' => function ($model, $key, $index) {
                return '<span class="label label-danger pull-right" style="min-width: 28px; padding: 5px; font-size: 15px">'. $model->quantity. '</span>';
            },
            'editableOptions' => function($model, $key, $index) {
                return [
                    'header' => 'Количество',
                    'inputType' => Editable::INPUT_TEXT,
                    'afterInput' => function ($form, $widget) use ($model, $index) {
                        return $form->field($model, "ref_of")->textInput(['id' => "shortage-{$index}-ref_of"]);
                    },
                    'formOptions' => ['action' => ['/elements/compensate-shortage']],
                ];
            },
//            'width' => '30px',
        ],       
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'status', 
            'format' => 'raw',
            //'refreshGrid' => true,
            'value' => function($model) {
                switch ($model->status) {
                    case Shortage::STATUS_NOACTIVE:
                        return '<span class="glyphicon glyphicon-hourglass" style="color: #fda901;"> Не погашено</span>';
                        break;
                    case Shortage::STATUS_ACTIVE:
                        return '<span class="glyphicon glyphicon-thumbs-up" style="color: blue;"> Частично погашено</span>';
                        break;
                    case Shortage::STATUS_CHANGED:
                        return '<span class="glyphicon glyphicon-thumbs-up" style="color: green;"> Найдена замена</span>';
                        break;
                    case Shortage::STATUS_CANCEL:
                        return '<span class="glyphicon glyphicon-thumbs-down" style="color: #ff0000;"> Отменено</span>';
                        break;
                    case Shortage::STATUS_CLOSE:
                        return '<span class="glyphicon glyphicon-thumbs-up" style="color: grey;"> Погашена</span>';
                        break;
                }
            },
            'editableOptions' => function($model, $key, $index) {
                return [
                    'header' => 'Статус',
                    'formOptions' => ['action' => ['/elements/change-status']],
                    'data' => [
                        Shortage::STATUS_NOACTIVE => 'Не погашено', 
                        Shortage::STATUS_ACTIVE => 'Частично погашено', 
                        Shortage::STATUS_CHANGED => 'Найдена замена', 
                        Shortage::STATUS_CANCEL => 'Отменено', 
                        Shortage::STATUS_CLOSE => 'Погашена', 

                    ],
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'afterInput' => function ($form, $widget) use ($model, $index) {
                        return $form->field($model, "note")->textarea(['id' => "shortage-{$index}-note", 'style' => "width: 100%;"]);
                    },
                    'size' => 'md',
                ];
            },
//            'width' => '330px',
//            'options' => [
//                'style' => 'width: 160px;',
//            ],
        ],
        [
            'attribute' => 'id',
            'options' => [
                'style' => 'width: 10px;',
            ],
        ],
        [
            'attribute' => 'idboard',
            'value' => function ($model, $key, $index) {
                if (!is_null($model->idboard)) {
                    return $model->idboard . '/' . Html::encode($model->boards->name) . ', ' . (!is_null($model->boards->themes) ?  Html::encode($model->boards->themes->name) : '');
                } elseif (!is_null($model->users)) {
                    return $model->users->surname . '/' . ((!is_null($model->themes)) ?  Html::encode($model->themes->name) : '');
                } else {
                    return '';
                }
            },
            'options' => [
                'style' => 'width: auto;',
            ],
        ],                       
        
    ],
]);