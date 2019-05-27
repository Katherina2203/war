<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Accounts */

$this->title = yii::t('app', 'Add item into invoice');
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-create">

    <?= $this->render('_formaddfast', [
        'model' => $model,
        'modelpr' => $modelpr,
        'modelpay' => $modelpay
    ]) ?>

</div>
