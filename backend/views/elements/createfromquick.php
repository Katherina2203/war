<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Взять со склада быстро';
$this->params['breadcrumbs'][] = ['label' => 'Со склада', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fromquick-create">

       <h2 class="box-title"><?= Html::encode($this->title) ?></h2>
    
        <?= $this->render('_formfromquick', [
            'model' => $model,
            'idel' => $model->idelement,
            'element' => $element,
            'board' => $board,
        ]) ?>


</div>
