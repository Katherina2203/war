<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товар в счете';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить товар в счет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idord',
            'idelem',
            [
                'attribute' => 'idelem',
                'label' => 'Название',
                'format' => 'raw',
               // 'value' => 'elements.name',
                'value' => function($model, $key, $index){
                    return Html::a($model->elements->name, ['elements/view', 'id' => $model->idelem]);
                },
            ],
            [
                'attribute' => 'idelem',
                'label' => 'Описание',
                'value' => 'elements.nominal',
            ],
        /*    [
                'attribute' => 'idelem',
                'label' => 'Производитель',
                'value' => function($data){
                    return $data->elements->manufacturerName;
                },
                'filter' => Html::activeDropDownList($searchModel, 'idelem', ArrayHelper::map(\common\models\Produce::find()->select(['idpr', 'manufacture'])->indexBy('idpr')->all(), 'idpr', 'manufacture'),['class'=>'form-control','prompt' => 'Выберите производител']),
            ],*/
            [
                'attribute' => 'idprice',
                'format' => 'raw',
                'value' => function($model, $key, $index){
                    return Html::a(($model->prices->unitPrice. '/' . $model->prices->forUP), ['prices/view', 'id' => $model->prices->idel]);
                }
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($data){
                    return '<strong><center>' .$data->quantity. '</strong></center>';
                }
            ],
            'amount',
            [
                'attribute' => 'idinvoice',
                'format' => 'raw',
                'value' => function($model, $key, $index){
                    return Html::a(($model->paymentinvoice->invoice), ['paymentinvoice/itemsin', 'id' => $model->idinvoice]);
                }
            ],
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
</div>
