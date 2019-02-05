<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Accounts */

$this->title = 'Create Accounts';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-addtoinvoice">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formaddtoinv', [
        'model' => $model,
        
    ]) ?>

</div>
