<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PayerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Плательщики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payer-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать плательщика', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
     <h1><?= Html::encode($this->title) ?></h1>
    <?php /* GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'idpayer',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model, $index){
                    return html::a($model->name, ['payer/view', 'id' => $index]);
                }
            ],
            
            'contact',
      
           // 'address',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */
      ?>

    
    
    <?= ListView::widget([
                            'dataProvider' =>  $dataProvider,
                            'options' => [
                                'tag' => 'div',
                                'class' => 'list-wrapper',
                                'id' => 'list-wrapper',
                            ],
                        //    'layout' => "{pager}\n{items}\n{summary}",
                            'itemView' => function ($model, $key, $index, $widget) {
                                return $this->render('_payerlist',['model' => $model]);

                                // or just do some echo
                                // return $model->title . ' posted by ' . $model->author;
                            },
                            'itemOptions' => [
                                'tag' => false,
                            ],
                            'pager' => [
                                  //  'pagination' => $pages,
                            
                            ],
                            'emptyText' => '<p>Список пуст</p>',
                            'summary' => 'Показано {count} из {totalCount}',
                        ]);
                        ?>
    
</div>
