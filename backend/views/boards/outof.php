<?php

//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Журнал заявок';
//$this->params['breadcrumbs'][] = $this->title;
//$getProject = ArrayHelper::map($modelTheme::find()->select(['idtheme', 'name'])->where(['status' => 'active'])->all(), 'idtheme', 'name');
//$getUser = ArrayHelper::map($modelUser::find()->select(['id', 'surname'])->all(), 'id', 'surname');
?>
<div class="tab-outofstock">
    <?= GridView::widget([
                                        'dataProvider' => $dataProvideroutof,
                                      //  'filterModel' => $searchModeloutof,
                                        'columns' => [
                                            'idofstock',
                                            'idelement',
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
                                                'attribute' => 'quantity',
                                                'format' => 'raw',
                                                'value' => function($data){
                                                    return '<strong><center>' . $data->quantity . '</center></strong>';
                                                }
                                            ],
                                            [
                                                'attribute' => 'iduser',
                                                'value' => 'users.surname',
                                               //   'filter' => Html::activeDropDownList($searchModeloutof, 'iduser', ArrayHelper::map(\common\models\Users::find()->select(['id', 'surname'])->indexBy('id')->all(), 'id', 'surname'),['class'=>'form-control','prompt' => 'Select user']),
                                            ],
                                           
                                            'date',
                                         //   'idtheme',
                                            [
                                               'attribute' => 'idprice',
                                               'label' => 'Цена',
                                               'value' => function($data){
                                                return empty($data->idprice) ? '-' : $data->prices->price;
                                                   //eturn $data->prices->unitPrice;
                                               }

                                            ],
                                            [
                                                'attribute' => 'idprice',
                                                'label' => 'USD',
                                                'value' => function($data){
                                                    return empty($data->idprice) ? '-' : $data->prices->usd;
                                                }
                                            ],
                                            [
                                                'label' => 'Сумма',
                                             //   'attribute' => 'amount',
                                             //   'footer' => backend\components\TotalPrice::pageTotal($dataProvider->models,'amount'),
                                               
                                            ],
                                            'ref_of_board',

                                            ['class' => 'yii\grid\ActionColumn',
                                             //'controller' => common\models\Outofstock   
                                                ],
                                        ],
                                    ]); ?>
</div>
