<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
?>

    <ul>
       <li>
            <?php   
             echo '<ul>';
        foreach ($dataProviderChild->models as $child) {
            echo "<li>";
                echo  Html::a(Html::encode($child->name). '<span> (' . $model->elements_count. ')</span>', Url::to(['items', 'id' => $model->idcategory]));
            echo '</li>';
            }?>
    </ul>
