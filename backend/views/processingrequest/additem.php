<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Processingrequest */

$this->title = 'Подсоединить заявку к базе';
$this->params['breadcrumbs'][] = ['label' => 'Журнал заявок к обработке', 'url' => ['byexecutor','iduser' => yii::$app->user->identity->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processingrequest-create col-md-6">
   
    <div class="box">
        <div class="box-body">
            <?= $this->render('_formadditem', [
              //  'model' => $model,
                'modelord' => $modelord,
           //     'modelel' => $modelel,
                'modelreq' => $modelreq,
              //  'searchModelel' => $searchModelel,
            ]) ?>
        </div>   
    </div>   

</div>


