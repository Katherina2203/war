<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
?>
<div class="row">
    <div class="col-sm-12" style="width: auto;">
        <div class="box box-warning">
            <div class="box-body" style="white-space: normal !important; word-wrap: break-word;">
                <?php Pjax::begin(['id' => 'historyorder', 'options' => ['style' => ""]]); ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataAccountsRequests,
                    'showOnEmpty' => false,
                    'emptyText' => '<table><tbody></tbody></table>',
                    'columns' => [
                        [
                            'attribute' => 'elements_id',
                            'label' => 'Прием товара',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->accounts_status == '2' ? 
                                    Html::a('<span class="glyphicon glyphicon-plus"></span>', ['createreceipt', 'idord' => $data->accounts_id, 'idel' => $data->elements_id], ['title' => 'Прием товара']) : '';
                            },
                        ],
                        [
                            'attribute' => 'requests_id',
                            'label' => '№ заявки',
                            'format' => 'raw',
                            'value' => function($data) {
                               return Html::a($data->requests_id, ['requests/view', 'id' => $data->requests_id]);
                            },
                        ],
                        [
                            'attribute' => 'requests_quantity',
                            'label' => 'Кол-во',
                            'format' => 'raw',
                        ],
//                        [
//                            'attribute' => 'expacted_quantity',
//                            'label' => 'Непост. кол-во',
//                            'format' => 'raw',
//                        ],
                        [
                            'attribute' => 'requests_status',
                            'label' => 'Статус заявки',
                            'format' => 'raw',
                            'value'=> function($data){
                                switch ($data->requests_status) {
                                    case '0': // Не обработано
                                        return '<span class="glyphicon glyphicon-unchecked" style="color: #d05d09"></span>';
                                        break;
                                    case '1': // Активна
                                        return '<span class="glyphicon glyphicon-ok" style="color: green"></span>';
                                        break;
                                    case '2': // Отменено
                                        return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"></span>';
                                        break;
                                    case '3': // Выполнено
                                        return '<span class="glyphicon glyphicon-saved" style="color:grey"></span>';
                                        break;
                                }
                            },
                            'filter' => ['0'=> 'Не обработано', '1' => 'Активна','2' => 'Отменено','3' => 'Выполнено']
                        ],
                                    
                        [
                            'attribute' => 'accounts_id',
                            'label' => '№ позиции в счете',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'unit_price',
                            'label' => 'Цена',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'accounts_quantity',
                            'label' => 'Заказ. кол-во',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => 'Сумма',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'invoice_name',
                            'label' => '№ счета',
                            'format' => 'raw',
                            'value' => function($data) {
                                return Html::a($data->invoice_name, ['paymentinvoice/itemsin', 'idinvoice' => $data->invoice_id]);   
                            }
                        ],
                        [
                            'attribute' => 'accounts_status',
                            'label' => 'Статус позиции',
                            'format' => 'raw',
                            'value'=> function($data){
                                switch ($data->accounts_status) {
                                    case '2': // Закано
                                        return '<span class="glyphicon glyphicon-ok" style="color: green"></span>';
                                        break;
                                    case '3': // На складе
                                        return '<span class="glyphicon glyphicon-saved" style="color:grey"></span>';
                                        break;
                                    case '4': // Отменено
                                        return '<span class="glyphicon glyphicon-remove" style="color: #b02c0d"></span>';
                                        break;
                                }
                            },
                        ],
                        [
                            'attribute' => 'users_name',
                            'label' => 'Заказчик',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'project_name',
                            'label' => 'Проект',
                            'format' => 'raw',
                            'value' => function($data) {
                                return $data->project_name . (is_null($data->board_id) ? '' : ' - ' . $data->board_id);   
                            }
                        ],
                    ],
                ]);
                                    ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div> 
</div>