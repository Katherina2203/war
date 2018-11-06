<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Boards */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Платы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boards-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       
        <?= Html::a('Update', ['update', 'id' => $model->idboards], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idboards], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
         <?= Html::a('Себестоимость', ['create'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="col-sm-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idboards',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => '<strong>'.$model->name.'</strong>', 
            ],
            [
                'attribute' => 'idtheme',
                'value' =>  ArrayHelper::getValue($model, 'themes.name'),
            ],
            [
                'attribute' => 'idthemeunit',
                'value' =>  ArrayHelper::getValue($model, 'themeunits.nameunit'),
            ],
            
            [
                'attribute' => 'current',
                'value' =>  ArrayHelper::getValue($model, 'users.surname'),
            ],
            'date_added',
            'discontinued',
        ],
    ]) ?>
    </div>
    <div class="col-lg-10">
        <h3>Перечень электронных компонентов</h3>
         <?= GridView::widget([
        'dataProvider' => $dataProvideroutof,
        'filterModel' => $searchModeloutof,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'idofstock',
            [
                'attribute' => 'idelement',
                'label' => 'Наименование',
                'value' => 'elements.name'
            ],
            [
                'attribute' => 'idelement',
                 'label' => 'Номинал',
                'value' => 'elements.nominal'
            ],
            [
                'attribute' => 'iduser',
                'value' => 'users.surname',
                
               //   'filter' => Html::activeDropDownList($searchModeloutof, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Select user']),
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
            'date',
         //   'idtheme',
          
            'ref_of_board',

            ['class' => 'yii\grid\ActionColumn',
             //'controller' => common\models\Outofstock   
                ],
        ],
    ]); ?>
    </div>
</div>

