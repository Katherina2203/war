<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

//use common\models\Price;
use common\models\Supplier;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поставщики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать поставщика', ['create'], ['class' => 'btn btn-success']) ?>
        <?php // Html::button('Создать поставщика +', ['value' => Url::to('create'), 'class' => 'btn btn-success', 'id' => 'modalButtonSupplier']) ?>
        <?php Modal::begin([
                'header' => '<b>' . Yii::t('app', 'Create new Supplier') . '</b>',
                'id' => 'modalSupplier',
                'size' => 'modal-md',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
            ]);
                echo "<div id='modal-content'>".
                        $this->render('create', ['model' => new Supplier()])
                . "</div>";

            Modal::end();?>
    </p>
    <?php Pjax::begin(['id'=>'suppliers']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
             //   ['class' => 'yii\grid\SerialColumn'],

                'idsupplier',
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function($data){
                        return Html::a(Html::encode($data->name), Url::to(['viewprice', 'id' => $data->idsupplier]));
                    }
                ],
                'address',
                'manager',
                'phone',
                'website',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php $this->registerJs(
   "$('#modalButtonSupplier').on('click', function() {
        $('#modalSupplier').modal('show')
            .find('#modal-content')
            .load($(this).attr('data-target'));
    });
  "
    );
?>
