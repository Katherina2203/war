<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Elements */

$this->title = 'Create Produce';
$this->params['breadcrumbs'][] = ['label' => 'Produce', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elements-create">

    <h3>Добавьте нового производителя</h3>

    <?= $this->render('_formproduce', [
        'model' => $model,
    ]) ?>

</div>
