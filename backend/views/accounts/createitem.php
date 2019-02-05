<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Accounts */

$this->title = 'Добавить товар в счет';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-createitem">
    <div class="box-body">
        <?= $this->render('_formitem', [
            'model' => $model,
            'modelpurchase' => $modelpurchase,
            //  'modelorder' => $modelorder,
            //  'dataProvider' => $dataProvider
        ]) ?>
    </div>
</div>
