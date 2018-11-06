<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Themeunits */
$this->title = 'Create unit';
$this->params['breadcrumbs'][] = ['label' => 'Current projects', 'url' => ['themes/indexshort']];
$this->params['breadcrumbs'][] = ['label' => 'unit #', 'url' => ['themes/units', 'idtheme' => $model->idtheme]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themeunits-createbytheme">

    <?= $this->render('_formbytheme', [
        'model' => $model,
    ])
      ?>
     

</div>
