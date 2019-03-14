<?php
// _list_item.php
use yii\helpers\Html;

use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\Payer;

?>

<div class="categorylist">

    <h3 class="title">
    <?= Html::a(Html::encode($model->name), Url::to(['payer/view', 'id' => $model->idpayer]), ['title' => $model->name]) ?>
    </h3>

</div>