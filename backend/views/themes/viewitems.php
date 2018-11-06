<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OutofstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Взято со склада';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outofstock-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Взять со склада', ['outofstock/create', 'iduser' => yii::$app->user->identity->id], ['class' => 'btn btn-success']) ?>
    </p>
   <div class="col-sm-6">
    <?php DetailView::widget([
        'model' => $modelboard,
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
      <div class="col-md-8">
         <h3>Добавить в перечень платы</h3>
         <?php  // $this->render('_searchelem', ['model' => $searchModelelem]); ?>
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
