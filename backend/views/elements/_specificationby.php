<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

//use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Текущие проекты';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php  
    echo "<ul>";
    foreach ($dataProviderSpecification->models as $specification) {
        
        echo "<li style='padding-bottom: 15px; border-bottom: 1px solid lightgrey'>";
        echo Html::a($specification->id. '/'.Html::encode($specification->boards->name), Url::to(['specification/index']), ['class' => 'product-title']).
                ', <span style="color:lightgrey">' . ((!is_null($specification->boards) && !is_null($specification->boards->themes)) ? $specification->boards->themes->name : '') . '</span>' . 
                '<br/><span>'. $specification->ref_of . '</span>';
        echo '<span class="label label-danger pull-right">'. $specification->quantity. '</span>';
        echo '<span class="label pull-right">'. html::a('Закрыть недостачу', ['elements/closeshortage', 'idel' => $specification->idelement, 'idboard' => $specification->idboard]). '</span>';
        echo '</li>';
    }
?>
    </ul>



