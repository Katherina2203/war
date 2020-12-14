<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Themes;
//use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Текущие проекты';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php  
        echo "<ol>";
            foreach ($dataProviderTheme->models as $project) {
            echo "<li style='padding-bottom: 15px; border-bottom: 1px solid lightgrey'>";
                    echo '<span style="color:lightgrey">' . $project->projectnumber . '</span>, ' . Html::a(Html::encode($project->name), Url::to(['themes/units', 'idtheme' => $project->idtheme]), ['class' => 'product-title']).
                            '<br/><span>'. $project->customer . '</span>';
                    echo '<span class="label label-success pull-right">'. $project->status. '</span>';
                    echo '</li>';
                    }?>
       </ol>



