<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Themes;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Текущие проекты';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(['id' => 'themes-indexshort']); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProviderTheme,
      //  'filterModel' => $searchModelTheme,
        'pjax' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'projectnumber',
                'contentOptions' => ['style' => 'max-width: 60px;white-space: normal'],
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function (Themes $modelTheme) {
                      return Html::a(Html::encode($modelTheme->name), Url::to(['units', 'id' => $modelTheme->idtheme]));
                },
               'contentOptions' => ['style' => 'max-width: 200px;white-space: normal'],
            ],
            [
                'attribute' => 'customer',
                'contentOptions' => ['style' => 'max-width: 120px;white-space: normal'],
            ],
             

          

        ],
    ]); ?>
<?php Pjax::end(); ?>  

