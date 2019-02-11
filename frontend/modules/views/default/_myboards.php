<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Boards;
//use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Текущие проекты';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php  
        echo "<ol>";
            foreach ($dataProviderBoard->models as $board) {
            echo "<li style='padding-bottom: 15px; border-bottom: 1px solid lightgrey'>";
                    echo Html::a(Html::encode($board->name), Url::to(['themes/units', 'idtheme' => $board->idtheme]), ['class' => 'product-title'])                 ;
                   
                    echo '</li>';
                    }?>
       </ol>



