<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model common\models\Requests */

$this->title = 'Создать заявку';
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-createintheme">

    <?= $this->render('_formcreateintheme', [
        'model' => $model,
    ]) ?>

</div>
