<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectshortcutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projectshortcuts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projectshortcut-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Projectshortcut'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'idshortcut',
                'contentOptions' => ['style' => 'max-width: 40px;white-space: normal'],
            ],
            [
                'attribute' => 'description',
               'contentOptions' => ['style' => 'max-width: 320px;white-space: normal'],
            ],
            [
                'attribute' => 'category',
                'value' => 'categoryshortcut.name',
                'filter' =>Html::activeDropDownList($searchModel, 'category', common\models\Categoryshortcut::getHierarchy(), (['class'=>'form-control','prompt' => 'Выберите категорию'])),
            ],
            [
                'attribute' =>'status',
                'format' => 'raw',
                'value' => function($data){
                    if($data->status == 0){
                        return '<span>Не выполнено</span>';
                    }elseif($data->status == 1){
                        return '<span>Выполнено</span>';
                    }
                   
                },
                'filter'=>['0' => 'Не выполнено', '1' => 'Выполнено'],
            ],
            [
                'attribute' => 'significance',
                
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
