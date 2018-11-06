<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use common\models\Produce;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProduceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Производители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produce-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Создать производителя', ['create'], ['class' => 'btn btn-success']) ?>
         <?= Html::button('Создать производителя +', ['value' => Url::to('produce/create'), 'class' => 'btn btn-success', 'id' => 'modalButtonProduce']) ?>
          <?php Modal::begin([
                'header' => '<b>' . Yii::t('app', 'Create new Produce') . '</b>',
                'id' => 'modalProduce',
                'size' => 'modal-md',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
            ]);
                echo "<div id='modal-content'>".
                        $this->render('create', ['model' => new Produce()])
                . "</div>";

            Modal::end();?>
            
    </p>
    <?php Pjax::begin(['id' => 'produces']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
              //  ['class' => 'yii\grid\SerialColumn'],

                'idpr',

                [
                    'attribute' =>'manufacture',
                    'format' => 'raw',
                    'value' => function($data){
                        return Html::a(Html::encode($data->manufacture), Url::to(['viewitem', 'id' => $data->idpr]));
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php $this->registerJs(
 // Вызов модального окна формы заказа
   "$('#modalButtonProduce').on('click', function() {
        $('#modalProduce').modal('show')
            .find('#modal-content')
            .load($(this).attr('data-target'));
    });
  "
    );
?>
