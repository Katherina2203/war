<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Outofstock */

$this->title = 'Закрыть недостачу';
$this->params['breadcrumbs'][] = ['label' => 'Со склада', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-create">

    <?= $this->render('_formcloseshortage', [
        'model' => $model,
      //  'idel' => $model->idelement,

       // 'user' => $user,
    ]) ?>

</div>
