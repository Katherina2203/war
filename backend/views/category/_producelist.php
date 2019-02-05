<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\Category;
?>

<div class="producelist">
    <?= Html::a($model->produce->manufacture, ['produce/info', 'idpr' => $model->idproduce])?><br/>
</div>