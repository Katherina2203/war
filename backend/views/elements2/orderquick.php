<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Заказать быстро';
$this->params['breadcrumbs'][] = ['label' => 'Со склада', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fromquick-create">
    <h1><?php echo $modelel->name. ', '. $modelel->nominal?></h1>
    <?= $this->render('_formorderquick', [
        'model' => $model,
       // 'modelel' => $modelel,
    ]) ?>

</div>
