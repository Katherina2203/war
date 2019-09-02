<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

?>
<div class="row">
    <div class="col-sm-12" style="width: auto;">
        <div class="box">
            <div class="box-body" style="white-space: normal !important; word-wrap: break-word;">
                <?php echo GridView::widget([
                    'dataProvider' => $providerAccountsForRequest,
                    'showOnEmpty' => false,
                    'summary' => '',
                    'emptyText' => '<table><tbody></tbody></table>',
                    'columns' => [
                        [
                            'attribute' => 'requests_id',
                            'label' => 'Добавить к позиции',
                            'format' => 'raw',
                            'value' => function($data) {
                                $request_id = \Yii::$app->request->get('idrequest');
                                if ($request_id != $data->requests_id) {
                                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['add-to-account', 'accounts_id' => $data->accounts_id, 'requests_id' => $request_id], ['title' => 'Добавить к позиции']);
                                } else {
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'requests_id',
                            'label' => '№ заявки',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'elements_id',
                            'label' => 'Элемент ID',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'elements_name',
                            'label' => 'Название',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'accounts_id',
                            'label' => '№ позиции',
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
                            'attribute' => 'delivery',
                            'label' => 'Доставка',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'date_receive',
                            'label' => 'Дата получения',
                            'format' => 'raw',
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div> 
</div>