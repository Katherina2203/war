<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view" style="background-color: #fff;">

    <h1><?php // Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-6" >
    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>false,
     /*   'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],*/
        'hover'=>true,
        'attributes' => [
          //  'id',
           
            'name',
            'surname',
            'username',
            'password',
            'email:email',
            [
                'attribute' => 'birthday',
                'format' => 'date',
            ],

        ],
    ]) ?>
</div>
    <div class="col-lg-4">
         <img src="<?= Url::to('@web/images/'.'users/kat.jpg')//Yii::$app->user->identity->photo) ?>" class="img-circle" alt="<?= Yii::$app->user->identity->surname?>"/>
    </div>
   </div>  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>

</div>
