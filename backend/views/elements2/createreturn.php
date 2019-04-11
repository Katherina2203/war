<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Вернуть на склад';
$this->params['breadcrumbs'][] = ['label' => 'На складе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returnitem-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formret', [
        'return' => $return,
        'idelement' => $return->idelement,
      
    ]) ?>

</div>
