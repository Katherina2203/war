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
        echo "<ull>";
            foreach ($dataProviderShortage->models as $shortage) {
            echo "<li style='padding-bottom: 15px; border-bottom: 1px solid lightgrey'>";
                    echo Html::a(Html::encode($shortage->boards->name), Url::to(['shortage/index']), ['class' => 'product-title']).
                            ', <span style="color:lightgrey">' . $shortage->boards->themes->name . '</span>, ' . 
                           '<br/><span>'. $shortage->ref_of . '</span>';
                    echo '<span class="label label-danger pull-right">'. $shortage->quantity. '</span>';
                    echo '</li>';
                    }?>
       </ul>



