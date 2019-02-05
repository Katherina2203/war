<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Requests */

$this->title = 'Update Request status: ' . $model->idrequest;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idrequest, 'url' => ['view', 'id' => $model->idrequest]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="requests-updatestatus">

    <?= $this->render('_formupdatestatus', [
        'model' => $model,
    ]) ?>

</div>
