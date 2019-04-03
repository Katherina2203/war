<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\Category;
use common\models\Elements;
use yii\widgets\Pjax;
?>

<div class="categorylist">
    <div class="box-header with-border">
        <strong class="category-link-title">
            <?= $model->idcategory.'-'. Html::encode($model->name);?>
        </strong>
    </div>
    
    <?php 
        $dataProviderChild = new ActiveDataProvider([
            'query'=> Category::find()->where("parent=:parent", [":parent"=>$model->idcategory])->groupBy('idcategory')->orderBy('name ASC') //, [":parent"=>$model->idcategory = 1]
        ]); 
        
        echo '<ul>';
        foreach ($dataProviderChild->models as $child) {
            echo "<li>";
                echo  Html::a(Html::encode($child->name). '  <span class="badge">' . $model->elements_count. '</span>', Url::to(['elements/viewcat', 'idcategory' => $child->idcategory])); //. '  <span class="badge">' . $model->elements_count. '</span>'
            echo '</li>';
            }?>
            
    </ul>

</div>