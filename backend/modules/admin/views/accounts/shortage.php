<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Недостачи по поставщикам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_searchelement', ['modelelem' => $searchModelelement]); ?>

    <p>
        <?= Html::a('Добавить товар в счет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'filterModel' => $searchModelelement,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'idord',
            'idelem',
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
                //'value' => 'elements.name',
                'value' => function ($model, $key, $index) { 
                    return Html::a($model->elements->name, ['elements/view', 'id' => $model->idelem]);
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
            [
                'attribute' => 'idprice',
                'format' => 'raw',
                'value' => function($data){
                    return $data->prices->price;
                }
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' . $data->quantity . '</center></strong>';
                }
            ],
            [
                'attribute' => 'paymentinvoice.idsupplier',
               /* 'value' => function($model, $key, $index){
                    return $model->paymentinvoice->idsupplier;
                }*/
            ],
          //  'account_date',
       //     'amount',
         /*   [
                'attribute' => 'idinvoice',
                'format' => 'raw',
                'value' => function($data){
                    return $data->idinvoice;
                }
            ],*/
            'delivery',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($model){
                    if($model->status == '2'){ //not active
                       return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"> Закано</span>';
                    }elseif($model->status == '3'){//active
                       return '<span class="glyphicon glyphicon-ok" style="color: green"> На складе</span>';
                    }
                },
                'filter' => ['2'=> 'Заказано', '3' => 'На складе']
            ],
            'date_receive',
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete} {receipt}',
             'buttons' => [
                 'receipt' => function ($url,$model,$key) {
                      $url = Url::to(['receipt', 'idord' => $key, 'idel' => $model->idelem]);
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['title' => 'Прием товара']);
                },
             ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
