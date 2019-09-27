<?php

//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал заявок';
$this->params['breadcrumbs'][] = $this->title;
//$getProject = ArrayHelper::map($modelTheme::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'name');
//$getUser = ArrayHelper::map($modelUser::find()->select(['id', 'surname'])->all(), 'id', 'surname');
?>
<div class="tab-specificationtemplate">
    <h2>Template of the specification</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProviderspectemp,
        'filterModel' => $searchModelspectemp,
        'columns' => [
            'idspt',
            'quantity',
            'idelement',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>
    
</div>
