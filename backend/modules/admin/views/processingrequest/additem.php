<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */

$this->title = 'Подсоединить заявку к базе';
$this->params['breadcrumbs'][] = ['label' => 'Подсоединить заявку к базе', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formadditem', [
        'model' => $model,
        'modelord' => $modelord,
        'modelel' => $modelel,
        'searchModelel' => $searchModelel,
    ]) ?>
    
    

</div>


