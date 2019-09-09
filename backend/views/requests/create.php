<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model common\models\Requests */

$this->title = 'Создать заявку';
//$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="col col-md-9">
        <div class="box">
             <div class="box-header with-border">
                        <h4><i class="glyphicon glyphicon-envelope"></i> Создать заявку</h4>
                        <span>Общие требования:</span>
                        <div class="pull-right box-tools">
                            <?php // Html::a('<i class="fa fa-times"></i>', ['#'], ['class' => 'btn btn-info btn-xs']) ?>
                        </div>
            </div>
            <div class="box-body">
                <div class="requests-create">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
</div>