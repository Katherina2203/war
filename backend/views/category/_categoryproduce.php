<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

?>

<div class="categoryproduce">
    <div class="box-header with-border">
        <strong class="category-link-title">
            <?= Html::encode($model->name) ?>
        </strong>
    </div>

    
   <?php  
        $modelcatpr = new \common\models\Categoryproduce();
        $dataProviderCatProduce = new ActiveDataProvider([
            'query'=> \common\models\Categoryproduce::find()->where(['idcategory' => $model->idcategory])->joinWith(['produce'], false),// Produce::find()//->where("parent=:parent", [":parent"=>$model->idcategory]) //, [":parent"=>$model->idcategory = 1]
        ]);
        
    echo '<ul>';
    
        
 
        foreach ($dataProviderCatProduce->models as $child) {
            echo "<li>";
            foreach ($dataProviderProduce->modelproduce as $produce) {
                echo Html::a($child->$produce->manufacture, Url::to(['produce/info', 'idpr' => $child->idproduce])); //. '/'. $child->produce->country
            }
            echo '</li>';
       
      }?>
    </ul>

</div>