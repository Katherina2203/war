<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Elements */

$this->title = 'Close shortage';
$this->params['breadcrumbs'][] = ['label' => 'Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcloseshortage', [
              //  'model' => $model,
                'modelout' => $modelout,
                'modelspecif' => $modelspecif,
    ]) ?>

</div>
